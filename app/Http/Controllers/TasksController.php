<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function add() {

        return view('task.add');
    }

    public function edit($taskId) {

        $task = Task::find($taskId);

        if(!$task) {
            return back()->with('error', 'Cannot find the task. Please try again or contact support.');
        }

        return view('task.edit', [
            'task' => $task
        ]);
    }

    public function save(Request $request) {

        try {
            if($request->has('task_id')) {
                $task = Task::find($request->get('task_id'));
                $infoMessage = 'Task updated successfully';
            } else {
                $task = new Task();
                $infoMessage = 'New task created successfully';
            }

            $task->user_id = Auth::user()->id;
            $task->title = $request->get('title');
            $task->description = $request->get('description');
            $task->due_date = $request->get('due_date');
            $task->status = $request->get('status');

            $task->save();
        } catch (\Exception $e) {
            Log::error(json_encode($e));

            return back()->with('error', 'Something went wrong. Please try again or contact support.');
        }

        return redirect()->route('dashboard')->with('info', $infoMessage);
    }

    public function delete($taskId) {
        try {
            $task = Task::find($taskId);

            if($task) {
                $task->delete();
            }
        } catch (\Exception $e) {
            Log::error(json_encode($e));

            return back()->with('error', 'Something went wrong. Please try again or contact support.');
        }

        return redirect()->route('dashboard')->with('info', 'Task has been deleted.');
    }
}
