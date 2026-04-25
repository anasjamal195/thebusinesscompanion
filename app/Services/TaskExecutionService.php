<?php

namespace App\Services;

use App\Models\AiCharacter;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use App\Models\UserProfile;
use App\Events\TaskLogCreated;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TaskExecutionService
{
    public function __construct(private readonly OpenRouterService $ai)
    {
    }

    public function classifyTask(string $input): array
    {
        $text = mb_strtolower(trim($input));

        $domain = 'general';
        $domainMatchers = [
            'marketing' => ['marketing', 'brand', 'positioning', 'campaign', 'seo', 'ads', 'funnel', 'copy', 'social'],
            'dev' => ['code', 'bug', 'laravel', 'php', 'react', 'api', 'database', 'migration', 'deploy', 'docker'],
            'trading' => ['trade', 'trading', 'forex', 'crypto', 'risk', 'portfolio', 'options', 'chart'],
            'sales' => ['sales', 'crm', 'leads', 'pipeline', 'closing', 'objections'],
            'ops' => ['operations', 'process', 'sop', 'workflow', 'logistics', 'inventory'],
            'finance' => ['cashflow', 'p&l', 'profit', 'margin', 'pricing', 'budget', 'forecast'],
        ];
        foreach ($domainMatchers as $d => $keywords) {
            foreach ($keywords as $k) {
                if (str_contains($text, $k)) {
                    $domain = $d;
                    break 2;
                }
            }
        }

        $complexity = 'simple';
        $len = mb_strlen($text);
        if ($len > 650 || str_contains($text, 'strategy') || str_contains($text, 'plan') || str_contains($text, 'analysis')) {
            $complexity = 'deep';
        }

        return ['domain' => $domain, 'complexity' => $complexity];
    }

    public function executeStructured(
        Task $task,
        User $user,
        ?UserProfile $profile,
        Project $project,
        array $recentTasks = [],
        ?AiCharacter $character = null,
        ?callable $log = null
    ): array {
        $ctx = $this->buildContext($task, $user, $profile, $project, $recentTasks);
        $classification = $this->classifyTask((string) $task->input_text);

        $this->emit($log, 'classify', 'Analyzing problem...', 'running');
        $this->emit($log, 'classify', "Task classified as domain={$classification['domain']}, complexity={$classification['complexity']}.", 'done');

        $this->emit($log, 'planner', 'Planning execution...', 'running');
        $plan = $this->planner($ctx, $classification, $character);
        $this->emit($log, 'planner', 'Execution plan ready.', 'done');

        $agents = array_values(array_unique(array_filter(array_map('strval', Arr::get($plan, 'agents', [])))));
        if (empty($agents)) {
            $agents = $this->defaultAgentsForDomain($classification['domain']);
        }

        $agentOutputs = [];
        foreach ($agents as $agentType) {
            $this->emit($log, 'agents', "Consulting {$agentType}...", 'running');
            $agentOutputs[$agentType] = $this->callAgent($agentType, $ctx, $plan, $character);
            $this->emit($log, 'agents', "{$agentType} input received.", 'done');
        }

        $this->emit($log, 'aggregate', 'Compiling final report...', 'running');
        $structured = $this->aggregator($ctx, $classification, $plan, $agentOutputs, $character);
        $this->emit($log, 'aggregate', 'Report compiled.', 'done');

        $finalText = $this->formatFinalText($structured);

        return [
            'final_text' => $finalText,
            'structured' => $structured,
            'plan' => $plan,
            'agents' => $agents,
            'classification' => $classification,
        ];
    }

    /**
     * Runs classification + planner + specialist agents (non-stream), returning artifacts needed for a streamed aggregator call.
     */
    public function planAndRunAgents(
        Task $task,
        User $user,
        ?UserProfile $profile,
        Project $project,
        array $recentTasks = [],
        ?AiCharacter $character = null,
        ?callable $log = null
    ): array {
        $ctx = $this->buildContext($task, $user, $profile, $project, $recentTasks);
        $classification = $this->classifyTask((string) $task->input_text);

        $this->emit($log, 'classify', 'Analyzing problem...', 'running');
        $this->emit($log, 'classify', "Task classified as domain={$classification['domain']}, complexity={$classification['complexity']}.", 'done');

        $this->emit($log, 'planner', 'Planning execution...', 'running');
        $plan = $this->planner($ctx, $classification, $character);
        $this->emit($log, 'planner', 'Execution plan ready.', 'done');

        $agents = array_values(array_unique(array_filter(array_map('strval', Arr::get($plan, 'agents', [])))));
        if (empty($agents)) {
            $agents = $this->defaultAgentsForDomain($classification['domain']);
        }

        $agentOutputs = [];
        foreach ($agents as $agentType) {
            $this->emit($log, 'agents', "Consulting {$agentType}...", 'running');
            $agentOutputs[$agentType] = $this->callAgent($agentType, $ctx, $plan, $character);
            $this->emit($log, 'agents', "{$agentType} input received.", 'done');
        }

        return [
            'classification' => $classification,
            'plan' => $plan,
            'agents' => $agents,
            'agent_outputs' => $agentOutputs,
        ];
    }

    public function streamAggregator(
        Task $task,
        User $user,
        ?UserProfile $profile,
        Project $project,
        array $recentTasks,
        ?AiCharacter $character,
        array $classification,
        array $plan,
        array $agentOutputs,
        int $maxTokens = 1400
    ): \Generator {
        $ctx = $this->buildContext($task, $user, $profile, $project, $recentTasks);

        $prompt = $this->aggregatorPrompt($ctx, $classification, $plan, $agentOutputs);
        $messages = [
            ['role' => 'system', 'content' => $this->systemFor('Aggregator', $character)],
            ['role' => 'user', 'content' => $prompt],
        ];

        $raw = '';
        foreach ($this->ai->streamChatCompletion($messages, $maxTokens) as $delta) {
            $raw .= $delta;
            yield ['type' => 'delta', 'text' => $delta];
        }

        $parsed = $this->parseJsonObject($raw);
        $structured = is_array($parsed) ? $this->normalizeStructured($parsed) : $this->normalizeStructured([]);
        yield ['type' => 'final_structured', 'structured' => $structured];
    }

    public function buildContext(Task $task, User $user, ?UserProfile $profile, Project $project, array $recentTasks = []): array
    {
        $role = $user->role ?: 'professional';

        $businessContext = $profile ? trim(implode("\n", array_filter([
            "Business: {$profile->business_name}",
            $profile->industry ? "Industry: {$profile->industry}" : null,
            $profile->business_type ? "Business type: {$profile->business_type}" : null,
            $profile->target_audience ? "Target audience: {$profile->target_audience}" : null,
            $profile->goals ? "Goals: {$profile->goals}" : null,
            $profile->challenges ? "Challenges: {$profile->challenges}" : null,
            $profile->experience_level ? "Experience level: {$profile->experience_level}" : null,
        ]))) : 'No business profile provided.';

        $projectContext = trim(implode("\n", array_filter([
            "Project: {$project->name}",
            $project->domain ? "Domain: {$project->domain}" : null,
            $project->objective ? "Objective: {$project->objective}" : null,
            $project->success_metric ? "Success metric: {$project->success_metric}" : null,
            $project->description ? "Description: {$project->description}" : null,
        ])));

        $recent = [];
        foreach (array_slice($recentTasks, 0, 5) as $rt) {
            $out = isset($rt['output']) ? (string) $rt['output'] : '';
            $out = Str::limit(preg_replace('/\s+/', ' ', $out) ?: '', 420);
            $recent[] = [
                'title' => (string) ($rt['title'] ?? ''),
                'status' => (string) ($rt['status'] ?? ''),
                'output' => $out,
            ];
        }

        return [
            'user_role' => $role,
            'business_context' => $businessContext,
            'project_context' => $projectContext,
            'recent_tasks' => $recent,
            'task' => [
                'title' => (string) $task->title,
                'priority' => (string) $task->priority,
                'input' => (string) $task->input_text,
            ],
        ];
    }

    public function persistLog(Task $task, string $step, string $message, string $status = 'info'): TaskLog
    {
        $log = $task->logs()->create([
            'step' => $step,
            'message' => $message,
            'status' => $status,
        ]);

        try {
            broadcast(new TaskLogCreated($log));
        } catch (\Throwable $e) {
            // Ignore broadcasting failures; logs are still persisted.
        }

        return $log;
    }

    private function planner(array $ctx, array $classification, ?AiCharacter $character): array
    {
        $prompt = $this->plannerPrompt($ctx, $classification);

        $content = $this->callAI(
            system: $this->systemFor('Planner', $character),
            user: $prompt,
            maxTokens: 700
        );

        $parsed = $this->parseJsonObject($content);
        if (!is_array($parsed)) {
            return [
                'steps' => ['Analyze problem', 'Develop solution', 'Create execution plan'],
                'agents' => $this->defaultAgentsForDomain($classification['domain']),
                'approach' => 'multi-step structured solution',
            ];
        }

        $steps = Arr::get($parsed, 'steps', []);
        $agents = Arr::get($parsed, 'agents', []);
        $approach = (string) Arr::get($parsed, 'approach', 'multi-step structured solution');

        return [
            'steps' => array_values(array_filter(array_map('strval', is_array($steps) ? $steps : []))),
            'agents' => array_values(array_filter(array_map('strval', is_array($agents) ? $agents : []))),
            'approach' => $approach,
        ];
    }

    private function callAgent(string $agentType, array $ctx, array $plan, ?AiCharacter $character): string
    {
        $prompt = $this->agentPrompt($agentType, $ctx, $plan);
        return $this->callAI(
            system: $this->systemFor($agentType, $character),
            user: $prompt,
            maxTokens: 900
        );
    }

    private function aggregator(array $ctx, array $classification, array $plan, array $agentOutputs, ?AiCharacter $character): array
    {
        $prompt = $this->aggregatorPrompt($ctx, $classification, $plan, $agentOutputs);
        $content = $this->callAI(
            system: $this->systemFor('Aggregator', $character),
            user: $prompt,
            maxTokens: 1200
        );

        $parsed = $this->parseJsonObject($content);
        return $this->normalizeStructured(is_array($parsed) ? $parsed : []);
    }

    private function normalizeStructured(array $data): array
    {
        $pickText = fn (string $k) => trim((string) Arr::get($data, $k, ''));
        $pickArr = function (string $k): array {
            $v = Arr::get($data, $k, []);
            if (is_string($v) && trim($v) !== '') {
                return [trim($v)];
            }
            if (!is_array($v)) {
                return [];
            }
            return array_values(array_filter(array_map(fn ($x) => trim((string) $x), $v), fn ($x) => $x !== ''));
        };

        return [
            'executive_summary' => $pickText('executive_summary') ?: $pickText('summary'),
            'problem_analysis' => $pickText('problem_analysis') ?: $pickText('analysis'),
            'proposed_solution' => $pickText('proposed_solution') ?: $pickText('solution') ?: $pickText('strategy'),
            'execution_plan' => $pickArr('execution_plan') ?: $pickArr('execution'),
            'tools_resources' => $pickArr('tools_resources') ?: $pickArr('tools') ?: $pickArr('resources'),
            'risks_considerations' => $pickArr('risks_considerations') ?: $pickArr('risks'),
            'next_actions' => $pickArr('next_actions'),
        ];
    }

    private function formatFinalText(array $structured): string
    {
        $s = $this->normalizeStructured($structured);

        $renderList = function (array $items): string {
            if (empty($items)) {
                return "—";
            }
            $out = [];
            foreach ($items as $i) {
                $out[] = "- {$i}";
            }
            return implode("\n", $out);
        };

        return trim(implode("\n\n", array_filter([
            "1. Executive Summary\n" . ($s['executive_summary'] !== '' ? $s['executive_summary'] : '—'),
            "2. Problem Analysis\n" . ($s['problem_analysis'] !== '' ? $s['problem_analysis'] : '—'),
            "3. Proposed Solution\n" . ($s['proposed_solution'] !== '' ? $s['proposed_solution'] : '—'),
            "4. Step-by-Step Execution Plan\n" . $renderList($s['execution_plan']),
            "5. Tools / Resources\n" . $renderList($s['tools_resources']),
            "6. Risks & Considerations\n" . $renderList($s['risks_considerations']),
            "7. Next Actions\n" . $renderList($s['next_actions']),
        ])));
    }

    private function plannerPrompt(array $ctx, array $classification): string
    {
        $recent = $this->renderRecent($ctx['recent_tasks'] ?? []);

        return trim(<<<PROMPT
You are a senior AI strategist.

Analyze the user's task and output ONLY valid JSON (no markdown, no commentary).

Context:
- User role: {$ctx['user_role']}
- Domain: {$classification['domain']}
- Complexity: {$classification['complexity']}

Business Context:
{$ctx['business_context']}

Project Context:
{$ctx['project_context']}

{$recent}

Task Input:
{$ctx['task']['input']}

Return JSON in this exact shape:
{
  "steps": ["..."],
  "agents": ["Researcher","Marketer","Engineer","Analyst"],
  "approach": "..."
}

Rules:
- steps: 3-7 items, imperative verb start, specific.
- agents: pick only what is needed (2-4).
- approach: one concise sentence.
PROMPT);
    }

    private function agentPrompt(string $agentType, array $ctx, array $plan): string
    {
        $steps = Arr::get($plan, 'steps', []);
        $stepsText = is_array($steps) && !empty($steps) ? implode("\n", array_map(fn ($s) => "- {$s}", $steps)) : "- Analyze problem\n- Develop solution\n- Plan execution";

        $recent = $this->renderRecent($ctx['recent_tasks'] ?? []);

        return trim(<<<PROMPT
You are a {$agentType} expert.

Context:
User role: {$ctx['user_role']}

Business Context:
{$ctx['business_context']}

Project Context:
{$ctx['project_context']}

{$recent}

Task:
{$ctx['task']['input']}

Execution Plan Steps (from planner):
{$stepsText}

Provide detailed professional input for your specialty:
- concrete, actionable recommendations
- assumptions and open questions
- avoid generic advice
PROMPT);
    }

    private function aggregatorPrompt(array $ctx, array $classification, array $plan, array $agentOutputs): string
    {
        $agentBlock = [];
        foreach ($agentOutputs as $agent => $text) {
            $agentBlock[] = strtoupper((string) $agent) . " INPUT:\n" . trim((string) $text);
        }
        $agentText = implode("\n\n", $agentBlock);

        $steps = Arr::get($plan, 'steps', []);
        $stepsText = is_array($steps) && !empty($steps) ? implode("\n", array_map(fn ($s) => "- {$s}", $steps)) : '';

        return trim(<<<PROMPT
You are a senior consultant.

Combine the following expert inputs into a structured, professional solution.
Output ONLY valid JSON (no markdown, no commentary).

Context:
- Domain: {$classification['domain']}
- Complexity: {$classification['complexity']}

Business Context:
{$ctx['business_context']}

Project Context:
{$ctx['project_context']}

Task Input:
{$ctx['task']['input']}

Planner Steps:
{$stepsText}

Expert Inputs:
{$agentText}

Return JSON in this exact shape:
{
  "executive_summary": "...",
  "problem_analysis": "...",
  "proposed_solution": "...",
  "execution_plan": ["..."],
  "tools_resources": ["..."],
  "risks_considerations": ["..."],
  "next_actions": ["..."]
}

Rules:
- execution_plan: 6-12 steps, ordered, each step is a single line.
- tools_resources / risks_considerations / next_actions: 3-8 items each.
- Be specific to the provided business + project context.
PROMPT);
    }

    private function systemFor(string $agentType, ?AiCharacter $character): string
    {
        // User-selected character acts as a global tone modifier.
        $characterAddon = '';
        if ($character) {
            $traits = '';
            if (is_array($character->meta)) {
                $metaTraits = $character->meta['traits'] ?? null;
                if (is_array($metaTraits)) {
                    $traits = trim(implode(', ', array_filter(array_map('strval', $metaTraits))));
                } elseif (is_string($metaTraits)) {
                    $traits = trim($metaTraits);
                }
            }
            if ($traits === '') {
                $traits = trim((string) ($character->tagline ?? ''));
            }
            if ($traits === '') {
                $traits = trim((string) ($character->bio ?? ''));
            }
            $characterAddon = "\n\nYou are {$character->name}, known for:\n" . ($traits !== '' ? $traits : 'clear thinking, structured outputs, and practical guidance') . "\nBehave accordingly.";
        }

        $base = match ($agentType) {
            'Planner' => 'You are a planning agent. You create concrete execution plans and select specialists.',
            'Researcher' => 'You are a research specialist. You gather relevant info and frame options, limitations, and assumptions.',
            'Marketer' => 'You are a marketing strategist. You focus on positioning, messaging, channels, and conversion.',
            'Engineer' => 'You are a senior engineer. You propose practical technical solutions with tradeoffs and implementation steps.',
            'Analyst' => 'You are an analyst. You validate logic, quantify where possible, and highlight risks.',
            'Creative' => 'You are a creative strategist. You generate differentiated ideas, angles, and copy directions.',
            'Aggregator' => 'You are a senior consultant. You synthesize inputs into a structured final answer.',
            default => 'You are an expert assistant. Be practical, specific, and structured.',
        };

        return $base . "\n\nOutput rules:\n- Do not reveal hidden chain-of-thought.\n- Prefer crisp, specific content.\n- Follow the user request strictly.\n" . $characterAddon;
    }

    private function callAI(string $system, string $user, int $maxTokens): string
    {
        $response = $this->ai->chatCompletion(
            [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
            stream: false,
            maxTokens: $maxTokens
        );

        if (!$response->successful()) {
            throw new \RuntimeException('AI request failed: ' . $response->status());
        }

        return trim((string) $response->json('choices.0.message.content', ''));
    }

    private function parseJsonObject(string $text): ?array
    {
        $text = trim($text);
        if ($text === '') {
            return null;
        }

        // Try direct decode first.
        $decoded = json_decode($text, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Otherwise attempt to extract the first {...} block.
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        $slice = substr($text, $start, $end - $start + 1);
        $decoded = json_decode($slice, true);
        return is_array($decoded) ? $decoded : null;
    }

    private function defaultAgentsForDomain(string $domain): array
    {
        return match ($domain) {
            'marketing' => ['Researcher', 'Marketer', 'Analyst'],
            'dev' => ['Engineer', 'Analyst'],
            'trading' => ['Analyst', 'Researcher'],
            'sales' => ['Marketer', 'Analyst'],
            'ops' => ['Analyst', 'Engineer'],
            'finance' => ['Analyst'],
            default => ['Researcher', 'Analyst'],
        };
    }

    private function renderRecent(array $recentTasks): string
    {
        if (empty($recentTasks)) {
            return '';
        }

        $lines = [];
        foreach ($recentTasks as $rt) {
            $title = (string) ($rt['title'] ?? '');
            $status = (string) ($rt['status'] ?? '');
            $out = (string) ($rt['output'] ?? '');
            $lines[] = "- {$title} ({$status}): " . ($out !== '' ? $out : '(no output yet)');
        }

        return "Recent context (last tasks only, not full history):\n" . implode("\n", $lines);
    }

    private function emit(?callable $log, string $step, string $message, string $status): void
    {
        if ($log) {
            $log($step, $message, $status);
        }
    }
}
