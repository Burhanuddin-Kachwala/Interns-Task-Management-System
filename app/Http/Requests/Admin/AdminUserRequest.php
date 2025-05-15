<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $adminId = $this->route('admin_user')?->id; // Null if creating

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $adminId,
            'role_id' => 'required|exists:roles,id',
        ];

        if ($this->isMethod('post')) {
            // Creating new admin
            $rules['password'] = 'required|min:6|confirmed';
        } else {
            // Updating existing admin
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
}
