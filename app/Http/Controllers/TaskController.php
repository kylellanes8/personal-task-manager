<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('due_date')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateTask($request);

        Task::create($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $this->validateTask($request);

        $task->update($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['Pending', 'Completed'])],
        ]);

        $task->update($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task status changed successfully.');
    }

    private function validateTask(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['Pending', 'Completed'])],
            'due_date' => ['required', 'date_format:Y-m-d'],
        ]);
    }
}
