<?php

namespace App\Http\Requests;

use App\Enums\UserIdTypeEnums;
use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
            'user_id_type' => ['required','string'],
            'user_id'  => $this->input('user_id_type') == UserIdTypeEnums::EMAIL ?  ['required','email','max:255'] : 
                        ['required','string','min:10','max:14','regex:/^[0-9]+$/'],
            'password'=> ['required','string','min:8'],
        ];
    }
}
