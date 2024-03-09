<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_day' => Carbon::create($this->start_day)->toDateString(),
            'end_day' => Carbon::create($this->end_day)->toDateString(),
            'status' => $this->status,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->user),
        ];
    }
}
