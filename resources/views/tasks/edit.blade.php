@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">Edit Task</h2>

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        @include('tasks.form', ['task' => $task])
    </form>
</div>
@endsection
