<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();
        return view('task.tasks', compact('tasks'));
    }

    public function create(){
        return view('task.new');
    }

    public function created(Request $request){
        $val = Validator::make((array)$request, [
            'name' => ['required', 'string', 'max:255'],
            'limit_date' => ['required', 'date'],
        ]);

        $task = Task::create([
            'name' => $request->get("name"),
            'limit_date' => $request->get("limit_date"),
            'user_id' => Auth::user()->id,
        ]);

        session(['task_created' => true]);
        return redirect()->route('log', $task);
    }

    public function update(Task $task){
        return view('task.update', compact('task'));
    }

    public function updated(Request $request, Task $task){
        $task->name = $request->get('name');
        $task->limit_date = $request->get('limit_date');
        $task->save();
        return redirect()->route('tasks_home');
    }

    public function destroy(Request $request, Task $task){
        $task->delete();
        return redirect()->route('tasks_home');
    }
}
