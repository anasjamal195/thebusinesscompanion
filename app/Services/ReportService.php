<?php

namespace App\Services;

use App\Models\Report;
use App\Models\Task;
use Illuminate\Support\Str;

class ReportService
{
    public function generateFromTask(Task $task): Report
    {
        $text = trim((string) optional($task->output)->output_text);
        $structured = optional($task->output)->structured_data;

        if (is_array($structured) && !empty($structured)) {
            $summary = trim((string) ($structured['executive_summary'] ?? $structured['summary'] ?? ''));
            $analysis = trim((string) ($structured['problem_analysis'] ?? $structured['analysis'] ?? ''));
            $strategy = trim((string) ($structured['proposed_solution'] ?? $structured['strategy'] ?? ''));
            $execution = $structured['execution_plan'] ?? $structured['execution'] ?? [];
            $next = $structured['next_actions'] ?? [];

            $insightsParts = array_filter([$analysis, $strategy], fn ($x) => trim((string) $x) !== '');
            $insights = trim(implode("\n\n", $insightsParts));
            $recommendations = is_array($execution) ? implode("\n", array_map(fn ($x) => "- " . trim((string) $x), $execution)) : '';
            if ($recommendations === '' && is_array($next)) {
                $recommendations = implode("\n", array_map(fn ($x) => "- " . trim((string) $x), $next));
            }

            return Report::updateOrCreate(
                ['task_id' => $task->id],
                [
                    'summary' => $summary !== '' ? Str::limit($summary, 800) : Str::limit($text, 500),
                    'insights' => $insights !== '' ? Str::limit($insights, 2400) : null,
                    'recommendations' => $recommendations !== '' ? Str::limit($recommendations, 2400) : null,
                    'structured_data' => $structured,
                ]
            );
        }

        $summary = $this->extractSection($text, ['summary', 'executive summary'], 500);
        if ($summary === '') {
            $summary = Str::limit($text, 500);
        }

        $insights = $this->extractSection($text, ['insights', 'key insights'], 1200);
        $recommendations = $this->extractSection($text, ['recommendations', 'next steps', 'actionable steps'], 1200);

        if ($insights === '' && $recommendations === '') {
            // Fallback split: first chunk as insights, remainder as recommendations.
            $chunks = preg_split("/\n{2,}/", $text) ?: [];
            $insights = Str::limit(trim((string) ($chunks[0] ?? '')), 1200);
            $recommendations = Str::limit(trim((string) ($chunks[1] ?? '')), 1200);
        }

        return Report::updateOrCreate(
            ['task_id' => $task->id],
            [
                'summary' => $summary !== '' ? $summary : null,
                'insights' => $insights !== '' ? $insights : null,
                'recommendations' => $recommendations !== '' ? $recommendations : null,
                'structured_data' => null,
            ]
        );
    }

    private function extractSection(string $text, array $headings, int $limit): string
    {
        if ($text === '') {
            return '';
        }

        $lower = mb_strtolower($text);
        foreach ($headings as $h) {
            $needle = mb_strtolower($h);
            $pos = mb_strpos($lower, $needle);
            if ($pos === false) {
                continue;
            }

            $slice = trim(mb_substr($text, $pos));
            $slice = preg_replace('/^[^\n]*\n/', '', $slice) ?? $slice;
            $end = preg_split("/\n{2,}/", $slice, 2) ?: [];
            $section = trim((string) ($end[0] ?? ''));
            return Str::limit($section, $limit);
        }

        return '';
    }
}
