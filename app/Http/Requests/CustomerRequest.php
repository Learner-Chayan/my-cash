<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'name'  => 'required',
            'email' => 'required|email|unique:users,email'
        ];

                // If the request is an update, modify the 'title' rule to ignore the current record.
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $customerId = $this->route('customer'); // Assuming 'customer' is the name of your route parameter
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($customerId),
            ];
        }

        return $rules;
    }
}
