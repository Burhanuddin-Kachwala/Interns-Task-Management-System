<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {       
        $roleId = optional($this->route('role'))->id;

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
        ];

        if (!$this->input('is_superadmin')) {
            $rules['permissions'] = 'required|array';
        }

        return $rules;
    }
}
