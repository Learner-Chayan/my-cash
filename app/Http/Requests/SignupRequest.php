<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormRequest;
use App\Enums\UserIdTypeEnums;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Enums\Status;

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
        $rules = [
            'user_id_type' => ['required','string'],
            'user_id'  => $this->input('user_id_type') == UserIdTypeEnums::EMAIL ? 
                        ['required','email',
                         Rule::unique('users','email')->where(function($query) {
                            return $query->where('status', Status::ACTIVE);
                         }),
                        'max:255'] 
                        : 
                        ['required','string','min:10',
                        Rule::unique('users','phone')->where(function($query) {
                            return $query->where('status', Status::ACTIVE);
                         }),
                        'max:14','regex:/^[0-9]+$/'],
            'confirm_password' => ['required','same:password'],
            'password' => [
                'required',
                'min:8',
                'max:32',
            ],
        ];



        // Validator::extend('char_required', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/[a-z]/', $value);
        // });
        Validator::extend('capital_char_required', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[A-Z]/', $value);
        });
        Validator::extend('digit_required', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\d/', $value);
        });
        Validator::extend('no_user_id_in_password', function ($attribute, $value, $parameters, $validator) {
            $user_id = $validator->getData()['user_id']; 
            // Check if the password does not contain the user_id (email or phone) as a substring
            return strpos($value, $user_id) === false;
        });

        // Add custom rule names to the 'password' field
       // $rules['password'][] = 'char_required';
        $rules['password'][] = 'capital_char_required';
        $rules['password'][] = 'digit_required';
        $rules['password'][] = 'no_user_id_in_password';

        return $rules;


    }

    public function messages()
    {
        return [
            //'password.char_required' => 'At least one letter is required',
            'password.capital_char_required' => 'At least one capital letter is required',
            'password.digit_required' => 'At least one digit is required',
            'password.no_user_id_in_password' => 'Email or phone should not contain in password',
        ];
    }

}
