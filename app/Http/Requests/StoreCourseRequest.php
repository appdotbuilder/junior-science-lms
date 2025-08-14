<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && (Auth::user()->isAdministrator() || Auth::user()->isTeacher());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:20|unique:courses,code',
            'grade_level' => 'required|in:7,8,9',
            'teacher_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Course name is required.',
            'code.required' => 'Course code is required.',
            'code.unique' => 'This course code is already in use.',
            'grade_level.required' => 'Grade level is required.',
            'grade_level.in' => 'Grade level must be 7, 8, or 9.',
            'teacher_id.required' => 'Teacher assignment is required.',
            'teacher_id.exists' => 'Selected teacher does not exist.',
        ];
    }
}