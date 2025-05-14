<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $permissionId = $this->route('permission')?->id;

        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permissionId,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Permission name is required.',
            'name.unique' => 'This permission name already exists.',
        ];
    }
}
