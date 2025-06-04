<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ CORRECT location for importing

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $priority = $request->query('priority');
        $sort = $request->query('sort', 'due_date');
        $order = $request->query('order', 'asc');

        // ✅ Get tasks only for the logged-in user
        $query = Task::where('user_id', Auth::id());

        if ($status && in_array($status, ['Pending', 'In Progress', 'Completed'])) {
            $query->where('status', $status);
        }

        if ($priority && in_array($priority, ['Low', 'Medium', 'High'])) {
            $query->where('priority', $priority);
        }

        if (in_array($sort, ['due_date', 'priority'])) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('due_date', 'asc');
        }

        $tasks = $query->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks', 'status', 'priority', 'sort', 'order'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        $validated['user_id'] = Auth::id(); // Or auth()->id()

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        if ($validated['status'] === 'Completed' && $task->status !== 'Completed') {
            \Log::info("Mock Email: Task '{$task->title}' marked as Completed by user ID " . Auth::id());
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
