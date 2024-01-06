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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required',"email", 'unique:users,email'],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/'],
        ];
    }
    public function messages()
    {
        return[
          'password.regex' => __('validation.password_regex')
        ];
    }
}
