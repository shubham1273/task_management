<div class="space-y-6">
    <div>
        <label for="title" class="block font-medium text-gray-700 dark:text-gray-200">Title</label>
        <input type="text" name="title" id="title"
            value="{{ old('title', $task->title ?? '') }}"
            required
            class="w-full mt-1 border border-gray-300 rounded-md px-4 py-2 dark:bg-gray-700 dark:text-white">
    </div>

    <div>
        <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Description</label>
        <textarea name="description" id="description" rows="4"
            class="w-full mt-1 border border-gray-300 rounded-md px-4 py-2 dark:bg-gray-700 dark:text-white">{{ old('description', $task->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="due_date" class="block font-medium text-gray-700 dark:text-gray-200">Due Date</label>
        <input type="date" name="due_date" id="due_date"
            value="{{ old('due_date', isset($task) ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
            required
            class="w-full mt-1 border border-gray-300 rounded-md px-4 py-2 dark:bg-gray-700 dark:text-white">
    </div>

    <div>
        <label for="status" class="block font-medium text-gray-700 dark:text-gray-200">Status</label>
        <select name="status" id="status" required
            class="w-full mt-1 border border-gray-300 rounded-md px-4 py-2 dark:bg-gray-700 dark:text-white">
            @foreach(['Pending', 'In Progress', 'Completed'] as $option)
                <option value="{{ $option }}" {{ old('status', $task->status ?? '') === $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="priority" class="block font-medium text-gray-700 dark:text-gray-200">Priority</label>
        <select name="priority" id="priority" required
            class="w-full mt-1 border border-gray-300 rounded-md px-4 py-2 dark:bg-gray-700 dark:text-white">
            @foreach(['Low', 'Medium', 'High'] as $option)
                <option value="{{ $option }}" {{ old('priority', $task->priority ?? '') === $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Submit and Back Buttons -->
    <div class="flex justify-between items-center pt-4">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
            {{ isset($task) ? 'Update Task' : 'Create Task' }}
        </button>

        <a href="{{ route('tasks.index') }}"
            class="text-blue-600 hover:underline font-semibold">
            ← Back to List
        </a>
    </div>
</div>
