@extends('admin.layouts.app', ['title' => 'Edit Voice — ' . $voice->name, 'activeNav' => 'voices', 'pageTitle' => 'Edit Voice'])

@section('content')
<form method="POST" action="{{ route('admin.voices.update', $voice) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.voices._form', ['voice' => $voice])
</form>
@endsection