@extends('admin.layouts.app', ['title' => 'Add Voice', 'activeNav' => 'voices', 'pageTitle' => 'Add Voice'])

@section('content')
<form method="POST" action="{{ route('admin.voices.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.voices._form', ['voice' => null])
</form>
@endsection