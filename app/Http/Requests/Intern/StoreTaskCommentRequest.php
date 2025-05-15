<?php

namespace App\Http\Requests\Intern;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // You can add additional auth logic here if needed
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:1000',
        ];
    }
}
