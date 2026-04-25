import { marked } from 'marked';
import DOMPurify from 'dompurify';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function renderMarkdownInto(el, markdownText) {
    // Do not treat every single newline as a <br> (it creates huge vertical gaps).
    const html = marked.parse(markdownText || '', { breaks: false, gfm: true });
    el.innerHTML = DOMPurify.sanitize(html);
}

let echoInstance = null;
function getEcho() {
    if (echoInstance) return echoInstance;

    window.Pusher = Pusher;

    const key = import.meta.env.VITE_PUSHER_APP_KEY;
    const host = import.meta.env.VITE_PUSHER_HOST;
    const port = Number(import.meta.env.VITE_PUSHER_PORT || 443);
    const scheme = import.meta.env.VITE_PUSHER_SCHEME || 'https';
    const cluster = import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1';

    echoInstance = new Echo({
        broadcaster: 'pusher',
        key,
        cluster,
        forceTLS: scheme === 'https',
        wsHost: host,
        wsPort: port,
        wssPort: port,
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json',
            },
        },
    });

    return echoInstance;
}

function appendUserMessage(container, text) {
    const userWrap = document.createElement('div');
    userWrap.className = 'flex justify-end';
    const bubble = document.createElement('div');
    bubble.className = 'max-w-[75%] rounded-xl bg-blue-600 px-4 py-3 text-sm text-white shadow-sm whitespace-pre-wrap';
    bubble.textContent = text;
    userWrap.appendChild(bubble);
    container.appendChild(userWrap);
    container.scrollTop = container.scrollHeight;
}

function appendAssistantBubble(container) {
    const aiWrap = document.createElement('div');
    aiWrap.className = 'flex justify-start';
    const stack = document.createElement('div');
    stack.className = 'max-w-[75%]';

    const logs = document.createElement('div');
    logs.className = 'mb-2 space-y-1 text-xs text-gray-500';

    const aiBubble = document.createElement('div');
    aiBubble.className = 'chat-md rounded-xl bg-gray-100 px-4 py-3 text-sm text-gray-900 shadow-sm';
    aiBubble.dataset.raw = '';
    stack.appendChild(logs);
    stack.appendChild(aiBubble);
    aiWrap.appendChild(stack);
    container.appendChild(aiWrap);
    container.scrollTop = container.scrollHeight;
    return { bubble: aiBubble, logs };
}

async function initProjectChat() {
    const container = document.getElementById('chat-messages');
    const form = document.getElementById('chat-form');
    if (!container || !form) return;

    const taskUrl = container.dataset.taskUrl;
    const projectId = container.dataset.projectId;
    if (!taskUrl || !projectId) return;

    let activeChannel = null;

    // Upgrade server-rendered assistant messages to Markdown on first load.
    container.querySelectorAll('.chat-md').forEach((node) => {
        if (node.dataset.mdInit === '1') return;
        node.dataset.mdInit = '1';
        const raw = node.textContent || '';
        node.dataset.raw = raw;
        renderMarkdownInto(node, raw);
    });

    function detachChannel() {
        if (!activeChannel) return;
        try {
            getEcho().leave(activeChannel);
        } catch {
            // ignore
        }
        activeChannel = null;
    }

    function titleFrom(text) {
        const cleaned = (text || '').trim().replace(/\s+/g, ' ');
        return cleaned.length > 70 ? cleaned.slice(0, 70) + '…' : (cleaned || 'Task');
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = form.querySelector('input[name="message"]');
        const value = input ? input.value.trim() : '';
        if (!value) return;

        // Optimistic UI: append user + create empty assistant bubble to stream into.
        if (input) input.value = '';
        appendUserMessage(container, value);
        const assistant = appendAssistantBubble(container);
        const assistantBubble = assistant.bubble;
        const logBox = assistant.logs;
        let renderQueued = false;

        function queueRender() {
            if (renderQueued) return;
            renderQueued = true;
            requestAnimationFrame(() => {
                renderQueued = false;
                renderMarkdownInto(assistantBubble, assistantBubble.dataset.raw || '');
            });
        }

        detachChannel();

        try {
            // Create a new task (each task is a fresh chat).
            const res = await fetch(taskUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    project_id: Number(projectId),
                    title: titleFrom(value),
                    input_text: value,
                    priority: 'medium',
                }),
            });
            if (!res.ok) {
                await res.text();
                return;
            }

            const json = await res.json();
            const taskId = json?.task?.id;
            if (!taskId) return;

            const channelName = `task.${taskId}`;
            activeChannel = channelName;

            const addLogRow = (message, status) => {
                const row = document.createElement('div');
                row.className = 'chat-log-row flex items-center gap-2';
                const dot = document.createElement('span');
                dot.className = 'inline-block h-1.5 w-1.5 rounded-full bg-gray-400';
                if (status === 'running') dot.className = 'inline-block h-1.5 w-1.5 rounded-full bg-blue-500';
                if (status === 'done') dot.className = 'inline-block h-1.5 w-1.5 rounded-full bg-green-600';
                if (status === 'error') dot.className = 'inline-block h-1.5 w-1.5 rounded-full bg-red-600';
                const msg = document.createElement('span');
                msg.textContent = message || '';
                row.appendChild(dot);
                row.appendChild(msg);
                logBox.appendChild(row);
                container.scrollTop = container.scrollHeight;
            };

            addLogRow('Queued task...', 'running');

            const echo = getEcho();
            const privateChannel = echo.private(channelName);

            privateChannel.listen('.task.log', (payload) => {
                addLogRow(payload?.message || '', payload?.status || 'info');
            });

            privateChannel.listen('.task.completed', (payload) => {
                addLogRow('Done.', 'done');

                const finalText = payload?.final_text || '';
                assistantBubble.dataset.raw = '';

                // Typing animation: reveal text quickly while re-rendering markdown.
                let idx = 0;
                const step = () => {
                    if (idx >= finalText.length) {
                        assistantBubble.dataset.raw = finalText;
                        queueRender();
                        return;
                    }
                    idx = Math.min(finalText.length, idx + 40);
                    assistantBubble.dataset.raw = finalText.slice(0, idx);
                    queueRender();
                    container.scrollTop = container.scrollHeight;
                    requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });
        } catch {
            // ignore
        } finally {
            // no-op
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initProjectChat();
});
