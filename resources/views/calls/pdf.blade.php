<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; line-height: 1.5; }
        h1 { font-size: 20px; margin: 0 0 4px 0; }
        .meta { color: #6b7280; font-size: 11px; margin-bottom: 20px; }
        .meta span { color: #111827; font-weight: 600; }
        .label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin-bottom: 4px; margin-top: 20px; }
        .info-grid { display: flex; gap: 24px; margin-bottom: 20px; }
        .info-item { }
        .info-value { font-size: 13px; font-weight: 600; }
        .info-label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.05em; color: #9ca3af; }
        .transcript { border: 1px solid #e5e7eb; padding: 14px; border-radius: 8px; white-space: pre-wrap; font-size: 11px; line-height: 1.7; }
        hr { border: none; border-top: 1px solid #e5e7eb; margin: 16px 0; }
    </style>
</head>
<body>
    <h1>Call Transcript</h1>
    <div class="meta">
        Call <span>#{{ $call->id }}</span> &middot;
        {{ $call->created_at->format('M d, Y h:i A') }}
    </div>

    <div class="info-grid">
        <div>
            <div class="info-label">Duration</div>
            <div class="info-value">{{ gmdate('i:s', $call->duration ?? 0) }}</div>
        </div>
        <div>
            <div class="info-label">Status</div>
            <div class="info-value">{{ ucfirst($call->status) }}</div>
        </div>
        <div>
            <div class="info-label">Direction</div>
            <div class="info-value">{{ ucfirst($call->direction ?? '—') }}</div>
        </div>
    </div>

    <hr>

    <div class="label">Full Transcript</div>
    <div class="transcript">{{ $call->transcript ?? 'No transcript available for this call.' }}</div>
</body>
</html>
