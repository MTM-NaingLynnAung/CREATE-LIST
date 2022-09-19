<?php

namespace App\Http\Requests;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:5',
            'c_password' => 'required|same:password'
            
        ];
    }
    public function messages()
    {
        return[
            'c_password.required' => 'Confirm Password is required',
            'c_password.same' => 'The Confirm Password and Password must match'
        ];
    }
}
