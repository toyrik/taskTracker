<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_day',
        'end_day',
        'user_id',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByStatus($query, $status)
    {
        switch ($status) {
            case TaskStatusEnum::CREATED->value:
                return $query->where('status', TaskStatusEnum::CREATED->value);
            case TaskStatusEnum::IN_PROGRESS->value:
                return $query->where('status', TaskStatusEnum::IN_PROGRESS->value);
            case TaskStatusEnum::DONE->value:
                return $query->where('status', TaskStatusEnum::DONE->value);
            default:
                return $query;
        }
    }
}
