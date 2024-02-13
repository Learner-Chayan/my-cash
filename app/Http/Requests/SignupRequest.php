<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormRequest;
use App\Enums\UserIdTypeEnums;
use Illuminate\Contracts\Validation\Validator;
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
       // dd($this->failedValidation);
        return [
            //'name'  => ['required','string'],
           // 'phone' => ['required','string','unique:users,phone','max:14','regex:/^[0-9]+$/'],
           // 'email' => ['required','email','unique:users,email','max:255'],
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
            'password' => ['required','min:6'],
            'confirm_password' => ['required','same:password'],
        ];
    }

}
