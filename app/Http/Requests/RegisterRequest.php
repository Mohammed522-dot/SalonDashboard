<?php

namespace App\Http\Requests;

use Dotenv\Validator;
use Facade\FlareClient\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:100|min:5',
            'phone' => 'required|unique:users|regex:/(249)[0-9]{9}/',
            'email'=>'unique:App\Models\User|email',
            'address'=>'required|max:100|min:5',
            'age'=>'required|min:10|numeric',
            'password' => 'required',

        ];
    }
  protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
{

    throw new \Illuminate\Validation\ValidationException(Response()->json($validator->errors(), 422));
}
}
