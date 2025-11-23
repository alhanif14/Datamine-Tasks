<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;

class TaskController extends Controller
{
    public function index(WeatherService $weatherService)
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        $weather = $weatherService->getCurrentWeather();
        return view('tasks.index', compact('tasks', 'weather'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|min:3|max:255',
        ]);

        $task->update([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index');
    }
    public function toggle(Task $task)
{
    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $task->update([
        'is_completed' => !$task->is_completed
    ]);

    return redirect()->back();
}
}