<?php

namespace App\Http\Controllers;

use App\Models\AiCharacter;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Project;
use App\Models\Task;
use App\Services\ReportService;
use App\Services\TaskExecutionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    public function stream(Request $request, Project $project, TaskExecutionService $executor, ReportService $reportService): StreamedResponse
    {
        abort_unless($project->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:8000'],
        ]);

        $user = $request->user()->loadMissing('profile');

        $conversation = Conversation::firstOrCreate(
            ['user_id' => $user->id, 'project_id' => $project->id],
            ['title' => $project->name]
        );

        ConversationMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        $taskTitle = Str::limit(trim($validated['message']), 72, '…');
        $task = Task::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'title' => $taskTitle !== '' ? $taskTitle : 'Chat Task',
            'input_text' => $validated['message'],
            'priority' => 'normal',
            'status' => 'processing',
            'context_snapshot' => null,
        ]);

        $character = null;
        if ($user->character_type) {
            $character = AiCharacter::query()->where('key', $user->character_type)->first();
        }

        $business = $user->profile ? trim(implode("\n", array_filter([
            "Business: {$user->profile->business_name}",
            $user->profile->industry ? "Industry: {$user->profile->industry}" : null,
            $user->profile->target_audience ? "Audience: {$user->profile->target_audience}" : null,
            $user->profile->goals ? "Goals: {$user->profile->goals}" : null,
            $user->profile->challenges ? "Challenges: {$user->profile->challenges}" : null,
            $user->profile->experience_level ? "Experience: {$user->profile->experience_level}" : null,
        ]))) : '';

        $projectCtx = trim(implode("\n", array_filter([
            "Project: {$project->name}",
            $project->domain ? "Domain: {$project->domain}" : null,
            $project->objective ? "Objective: {$project->objective}" : null,
            $project->success_metric ? "Success metric: {$project->success_metric}" : null,
        ])));

        // Memory: last N messages (small context window, chat-like).
        $history = $conversation->messages()
            ->latest('id')
            ->limit(20)
            ->get()
            ->reverse()
            ->values();

        $headers = [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, no-transform',
            'X-Accel-Buffering' => 'no',
        ];

        return response()->stream(function () use ($executor, $reportService, $task, $user, $project, $conversation, $character) {
            $assistantText = '';

            echo "event: start\n";
            echo "data: " . json_encode(['task_id' => $task->id]) . "\n\n";
            @ob_flush();
            flush();

            $emitLog = function (string $step, string $message, string $status = 'info') use ($executor, $task) {
                $executor->persistLog($task, $step, $message, $status);
                echo "event: log\n";
                echo "data: " . json_encode(['step' => $step, 'message' => $message, 'status' => $status]) . "\n\n";
                @ob_flush();
                flush();
            };

            try {
                $recentTasks = $task->newQuery()
                    ->where('project_id', $task->project_id)
                    ->where('id', '!=', $task->id)
                    ->with('output')
                    ->latest('id')
                    ->limit(3)
                    ->get()
                    ->map(fn ($t) => [
                        'title' => $t->title,
                        'status' => $t->status,
                        'output' => optional($t->output)->output_text,
                    ])
                    ->all();

                $result = $executor->executeStructured(
                    $task,
                    $user,
                    $user->profile,
                    $project,
                    $recentTasks,
                    $character,
                    log: $emitLog
                );
                $finalText = (string) ($result['final_text'] ?? '');
                $finalStructured = $result['structured'] ?? null;

                DB::transaction(function () use ($task, $finalText, $finalStructured, $reportService) {
                    $task->output()->updateOrCreate(
                        ['task_id' => $task->id],
                        ['output_text' => $finalText, 'structured_data' => is_array($finalStructured) ? $finalStructured : null]
                    );

                    $task->update(['status' => 'completed']);
                    $reportService->generateFromTask($task->fresh('output'));
                });

                // Simulated streaming: send the final formatted answer in chunks.
                $chunks = str_split($finalText, 120);
                foreach ($chunks as $chunk) {
                    $assistantText .= $chunk;
                    echo "event: delta\n";
                    echo "data: " . json_encode(['text' => $chunk]) . "\n\n";
                    @ob_flush();
                    flush();
                }
            } catch (\Throwable $e) {
                $emitLog('error', 'Something went wrong while generating the response.', 'error');

                DB::transaction(function () use ($task) {
                    $task->update(['status' => 'pending']);
                });

                throw $e;
            }

            DB::transaction(function () use ($conversation, $assistantText, $task) {
                ConversationMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'assistant',
                    'content' => trim($assistantText),
                    'meta' => ['task_id' => $task->id],
                ]);
            });

            echo "event: done\n";
            echo "data: {}\n\n";
            @ob_flush();
            flush();
        }, 200, $headers);
    }
}
