<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required','string'],
            'phone' => ['required','string','unique:users,phone','max:14','regex:/^[0-9]+$/'],
            'email' => ['required','email','unique:users,email','max:255'],
            'password' => ['required','min:6'],
            'confirm_password' => ['required','same:password'],
        ];
    }
}
