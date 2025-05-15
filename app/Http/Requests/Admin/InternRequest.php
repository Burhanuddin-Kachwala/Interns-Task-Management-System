<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InternRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $internId = $this->route('intern') ? $this->route('intern')->id : null;

        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:interns,email,' . $internId,
            'password' => 'nullable|min:6|confirmed', 
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The intern name is required.',
            'email.required' => 'The intern email is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
