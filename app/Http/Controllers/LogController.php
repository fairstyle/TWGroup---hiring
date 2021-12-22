<?php

namespace App\Http\Controllers;

use App\Mail\NewLogMail;
use App\Models\Log;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    public function index(Task $task){
        if (!$task || $task->user_id != Auth::user()->id) {
            session(['prohibido' => true]);
            return redirect()->route('tasks_home');
        }

        $logs = $task->logs()->get();
        return view('log.logs', compact('logs', 'task'));
    }

    public function create(Task $task){
        if (!$task || $task->user_id != Auth::user()->id) {
            session(['prohibido' => true]);
            return redirect()->route('tasks_home');
        }

        return view('log.new', compact('task'));
    }

    public function created(Request $request, Task $task){
        if (!$task || $task->user_id != Auth::user()->id) {
            session(['prohibido' => true]);
            return redirect()->route('tasks_home');
        }

        $val = Validator::make((array)$request, [
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $log = Log::create([
            'coment' => $request->get('coment'),
            'task_id' => $task->id,
        ]);

        //Mail::to($request->user())->send(new NewLogMail($log));

        session(['log_created' => true]);
        return redirect()->route('log', $task);
    }
}
