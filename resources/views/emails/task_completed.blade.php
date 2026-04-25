<x-mail::message>
# Task Completed

Hello {{ $task->user->name ?? 'there' }},

The Business Companion has completed the task **"{{ $task->title }}"**.

We have attached the comprehensive report to this email. You can also view your task online by visiting your dashboard.

<x-mail::button :url="route('projects.show', $task->project_id)">
View Project Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
