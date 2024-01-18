<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $taskStatuses = TaskStatus::select('id', 'name')->pluck('name', 'id');
        $users = User::select('id', 'name')->pluck('name', 'id');
        $filter = $request->filter ?? null;
        $query = Task::query();
        if (is_array($filter)) {
            if ($filter['status_id']) {
                $query->where('status_id', $filter['status_id']);
            }
            if ($filter['created_by_id']) {
                $query->where('created_by_id', $filter['created_by_id']);
            }
            if ($filter['assigned_to_id']) {
                $query->where('assigned_to_id', $filter['assigned_to_id']);
            }
        }
        $tasks = $query->paginate();
        return view('tasks.index', 
        [
            'tasks' => $tasks,
            'taskStatuses' => $taskStatuses,
            'users' => $users, 'filter' => $filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()) {
            $task = new Task();
            $task_statuses = TaskStatus::select('id', 'name')->pluck('name', 'id');
            $users = User::select('id', 'name')->pluck('name', 'id');
            $labels = Label::select('id', 'name')->pluck('name', 'id');
            return view('tasks.create',
                [
                    'task' => $task,
                    'task_statuses' => $task_statuses,
                    'users' => $users,
                    'labels' => $labels,
                ]
            );
        }
        abort(403, 'Пользователь не авторизирован.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()) {
            $data = $this->validate($request, [
                'name' => 'required|unique:tasks|max:255',
                'description' => 'nullable|max:1000',
                'status_id' => 'required',
                'assigned_to_id' => 'nullable',
            ]);
            $task = new Task();
            $labels = $request->input('labels', []);  
            $data['created_by_id'] = auth()->user()->id;
            $task->fill($data);
            $task->save();
            $task->labels()->attach($labels);
            $task->creator()->associate(auth()->user()->id);
            return redirect()->route('tasks.index');
        }
        abort(403, 'Пользователь не авторизирован.');
    }

    public function attachCategories($categories) {
        $this->categories()->attach($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (auth()) {
            $task_statuses = TaskStatus::select('id', 'name')->pluck('name', 'id');
            $users = User::select('id', 'name')->pluck('name', 'id');
            $labels = Label::select('id', 'name')->pluck('name', 'id');
            return view('tasks.edit',
                [
                    'task' => $task,
                    'task_statuses' => $task_statuses,
                    'users' => $users,
                    'labels' => $labels,
                ]
            );
        }
        abort(403, 'Пользователь не авторизирован.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (auth()) {
            $data = $this->validate($request, [
                'name' => 'required|unique:tasks|max:255',
                'description' => 'nullable|max:1000',
                'status_id' => 'required',
                'assigned_to_id' => 'nullable',
            ]);
            $labels = $request->input('labels', []);
            $account = $request->input('users');
            $task->fill($data);
            $task->save();
            $task->labels()->detach();
            $task->labels()->attach($labels);
            $task->creator()->dissociate();
            $task->creator()->associate($account);
            return redirect()->route('tasks.index');
    }
    abort(403, 'Пользователь не авторизирован.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
        }
        return redirect()->route('task.index');
    }
}
