<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TasksResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $tasks = User::find($user)->tasks;
        // $tasks = $tasks->makeHidden(['user_id']);
        return response(['status' => 'true', 'message' => 'Tasks retrieved successfully', 'data' => TasksResource::collection($tasks)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validateData = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        // validate input
        if ($validateData->fails()) {
            return response(['error' => $validateData->errors(), 'Validation Error'], 400);
        }
        // create task
        $data['user_id'] = Auth::user()->id;
        $task = Tasks::create($data);
        $task = $task->makeHidden(['user_id']);
        // return response
        return response(['status' => 'true', 'message' => 'Tasks created successfully', 'data' => new TasksResource($task)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $task)
    {
        return response(['status' => 'true', 'message' => 'Task retrieved successfully','data' => new TasksResource($task->makeHidden(['user_id']))], 200);
    }

    public function tasksByStatus(Request $request, $status)
    {
        $user = Auth::user()->id;
        $tasks = User::find($user)->tasks()->where('status', $status)->get();
        $tasks = $tasks->makeHidden(['user_id']);
        return response(['status' => 'true', 'message' => 'Task retrieved successfully', 'data' => new TasksResource($tasks)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $task)
    {
        $task->update($request->all());
        $task->makeHidden(['user_id']);
        return response(['status' => 'true', 'message' => 'Tasks updated successfully', 'data' => new TasksResource($task)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $task)
    {
        $task->delete();
        return response(['status' => 'true', 'message' => 'Task deleted successfully'], 200);
    }
}
