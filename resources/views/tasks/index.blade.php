@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 bg-gray-900 min-h-screen text-white rounded-md shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
            + Create Task
        </a>
    </div>

    <!-- Filters Form -->
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 flex flex-wrap gap-6 items-end">
        <div>
            <label for="status" class="block mb-1 font-semibold">Filter by Status:</label>
            <select name="status" id="status" class="border rounded px-3 py-1 text-black w-40">
                <option value="">All</option>
                @foreach(['Pending', 'In Progress', 'Completed'] as $option)
                    <option value="{{ $option }}" {{ (request('status') == $option) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="priority" class="block mb-1 font-semibold">Filter by Priority:</label>
            <select name="priority" id="priority" class="border rounded px-3 py-1 text-black w-40">
                <option value="">All</option>
                @foreach(['Low', 'Medium', 'High'] as $option)
                    <option value="{{ $option }}" {{ (request('priority') == $option) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sort" class="block mb-1 font-semibold">Sort by:</label>
            <select name="sort" id="sort" class="border rounded px-3 py-1 text-black w-40">
                <option value="due_date" {{ (request('sort') == 'due_date') ? 'selected' : '' }}>Due Date</option>
                <option value="priority" {{ (request('sort') == 'priority') ? 'selected' : '' }}>Priority</option>
            </select>
        </div>

        <div>
            <label for="order" class="block mb-1 font-semibold ">Order:</label>
            <select name="order" id="order" class="border rounded px-3 py-1 text-black w-40" >
                <option value="asc" {{ (request('order') == 'asc') ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ (request('order') == 'desc') ? 'selected' : '' }}>Descending</option>
            </select>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow font-semibold">
                Apply
            </button>
        </div>
    </form>

    <!-- Tasks Table -->
    <div class="overflow-x-auto rounded-md shadow-md">
        <table class="min-w-full bg-gray-800 border border-gray-700 text-white">
            <thead>
                <tr>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Title</th>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Description</th>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Due Date</th>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Status</th>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Priority</th>
                    <th class="px-4 py-3 border border-gray-700 text-left font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">{{ $task->title }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $task->description }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $task->due_date->format('Y-m-d') }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $task->status }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $task->priority }}</td>
                        <td class="border border-gray-700 px-4 py-2 space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-400 hover:underline">Edit</a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6">No tasks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
</div>
@endsection
