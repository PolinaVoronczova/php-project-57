<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task_statuses = TaskStatus::paginate();
        return view('task_statuses.index', compact('task_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task_status = new TaskStatus();
        return view('task_statuses.create', compact('task_status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'name' => 'required',
        ]);
        $status = new TaskStatus();
        $status->fill($data);
        $status->save();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        $task_status = $taskStatus;
        return view('task_statuses.edit', compact('task_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            return back();
        }
        $taskStatus->delete();
        return redirect()->route('task_statuses.index');
    }
}
