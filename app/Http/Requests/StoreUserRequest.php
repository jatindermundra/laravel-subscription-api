<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'dob'          => ['nullable', 'date', 'before:today'],
            'gender'       => ['nullable', 'in:male,female,other'],
            'emp_type'     => ['nullable', 'in:full_time,part_time,contract,freelance,unemployed'],
        ];
    }
}