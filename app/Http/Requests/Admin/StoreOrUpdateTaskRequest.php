<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
       
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'interns'     => 'nullable|array',
            'interns.*'   => 'exists:interns,id',
        ];
    }
}
