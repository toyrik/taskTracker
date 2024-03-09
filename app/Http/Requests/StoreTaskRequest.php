<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2',
            'description' => 'nullable|string|min:6',
            'start_day' => ['required'],
            'end_day' => ['required'],
            'status' => ['required', Rule::in(TaskStatusEnum::values())],
            'user_id' => ['nullable'],
        ];
    }
}
