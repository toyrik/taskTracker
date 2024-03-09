<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\HttpRes;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use HttpRes;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TaskResource::collection(
            Task::when(!auth()->user()->is_admin, function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })
                ->when($request->status, function ($query) use ($request) {
                return $query->FilterByStatus($request->status);
            })->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $storeArr = [
            'title' =>  $request->title,//'required|string|min:2',
            'start_day' => $request->start_day,
            'end_day' => $request->end_day,
            'status' => $request->status,
        ];
        if ($request->has('description')) {
            $storeArr['description'] = $request->description;
        }
        if ($request->has('user_id')) {
            $storeArr['user_id'] = $request->user_id;
        } else {
            $storeArr['user_id'] = auth()->user()->id;
        }

        $data = Task::create($storeArr);
        $task = TaskResource::collection(Task::where('id', $data->id)->get());

        return $this->success('201', 'Task Added Successfully', $task[0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = TaskResource::collection(Task::where('id', $id)->get());

        return $this->success('200', '', $task[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->error('404', 'Task Not Found');
        }

        if (auth()->user()->is_admin || $task->user_id === auth()->user()->id) {
            $storeArr = $this->fillTask($request);
            Task::where('id', $id)->update($storeArr);
            $task = TaskResource::collection(Task::where('id', $id)->get());

            return $this->success('201', 'Task Update Successfully', $task[0]);
        }

        return $this->error('403', 'This Action Is Unauthorized');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->error('404', 'Task not found');
        }

        if (auth()->user()->is_admin || $task->user_id === auth()->user()->id) {
            $task->destroy($id);
            return $this->success('200', 'Task Deleted Successfully', []);
        }

        return $this->error('403', 'This Action Is Unauthorized');
    }

    private function fillTask(StoreTaskRequest $request)
    {
        $data = [
            'title' =>  $request->title,
            'start_day' => $request->start_day,
            'end_day' => $request->end_day,
            'status' => $request->status,
        ];
        if ($request->has('description')) {
            $data['description'] = $request->description;
        }
        if ($request->has('user_id')) {
            $data['user_id'] = $request->user_id;
        } else {
            $data['user_id'] = auth()->user()->id;
        }

        return $data;
    }

}
