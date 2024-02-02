<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.™
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exists',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 20 characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number',
        ];
    }
}
