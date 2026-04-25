@php
    /** @var \App\Models\Report $report */
    /** @var \App\Models\Task $task */
    /** @var \App\Models\Project $project */
    $sd = is_array($report->structured_data) ? $report->structured_data : null;
    $list = fn ($v) => is_array($v) && !empty($v) ? implode("\n", array_map(fn ($x) => "- " . trim((string) $x), $v)) : "—";
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin: 0 0 6px 0; }
        .muted { color: #6b7280; font-size: 11px; margin-bottom: 16px; }
        h2 { font-size: 13px; margin: 18px 0 6px 0; }
        .box { border: 1px solid #e5e7eb; padding: 10px 12px; border-radius: 8px; }
        pre { white-space: pre-wrap; margin: 0; }
    </style>
</head>
<body>
    <h1>Report</h1>
    <div class="muted">Project: {{ $project->name }} · Task: {{ $task->title }}</div>

    @if ($sd)
        <h2>Executive Summary</h2>
        <div class="box"><pre>{{ $sd['executive_summary'] ?? '—' }}</pre></div>

        <h2>Problem Analysis</h2>
        <div class="box"><pre>{{ $sd['problem_analysis'] ?? '—' }}</pre></div>

        <h2>Proposed Solution</h2>
        <div class="box"><pre>{{ $sd['proposed_solution'] ?? '—' }}</pre></div>

        <h2>Step-by-Step Execution Plan</h2>
        <div class="box"><pre>{{ $list($sd['execution_plan'] ?? []) }}</pre></div>

        <h2>Tools / Resources</h2>
        <div class="box"><pre>{{ $list($sd['tools_resources'] ?? []) }}</pre></div>

        <h2>Risks & Considerations</h2>
        <div class="box"><pre>{{ $list($sd['risks_considerations'] ?? []) }}</pre></div>

        <h2>Next Actions</h2>
        <div class="box"><pre>{{ $list($sd['next_actions'] ?? []) }}</pre></div>
    @else
        <h2>Executive Summary</h2>
        <div class="box"><pre>{{ $report->summary ?: '—' }}</pre></div>

        <h2>Insights</h2>
        <div class="box"><pre>{{ $report->insights ?: '—' }}</pre></div>

        <h2>Recommendations</h2>
        <div class="box"><pre>{{ $report->recommendations ?: '—' }}</pre></div>
    @endif
</body>
</html>

