<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest
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
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo es obligatorio',
            'email.string' => 'El correo debe de ser una cadena de texto',
            'email.max' => 'El correo no debe superar los 255 caracteres',
            'email.email' => 'El correo debe de ser valido ',
            'password.required' => 'La contraseña es obligatorio',
            'password.string' => 'La contraseña debe de ser una cadena de texto',
            'password.min' => 'La contraseña debe superar los 8 caracteres',
        ];
    }
}
