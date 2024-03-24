<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPassRequest extends FormRequest
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
        $rules = [
            'phone' => 'nullable|exists:users,phone',
            'email' => 'nullable|exists:users,email',
        ];

        if ($this->route()->named('send-otp-phone')) {
            $rules['phone'] = 'required|exists:users,phone';
        }

        if ($this->route()->named('send-otp-email')) {
            $rules['email'] = 'required|exists:users,email';
        }

        return $rules;
    }
}
