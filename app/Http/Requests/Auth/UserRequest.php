<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class UserRequest extends ApiFormRequest
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
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe de ser una cadena de texto',
            'name.max' => 'El nombre no debe superar los 50 caracteres',
            'surname.required' => 'Los apellidos son obligatorios',
            'surname.string' => 'Los apellido deben de ser una cadena de texto',
            'surname.max' => 'Los apellidos no deben superar los 100 caracteres',
            'email.required' => 'El correo es obligatorio',
            'email.string' => 'El correo debe de ser una cadena de texto',
            'email.max' => 'El correo no debe superar los 255 caracteres',
            'email.unique' => 'El correo ya esta en uso',
            'email.email' => 'El correo debe de ser valido ',
            'password.required' => 'La contraseña es obligatorio',
            'password.string' => 'La contraseña debe de ser una cadena de texto',
            'password.min' => 'La contraseña debe superar los 8 caracteres',
            'confirm_password.required' => 'La contraseña es obligatorio',
            'confirm_password.string' => 'La contraseña debe de ser una cadena de texto',
            'confirm_password.min' => 'La contraseña debe superar los 255 caracteres',
            'role.required' => 'El rol es obligatorio',
            'role.string' => 'El rol debe de ser una cadena de texto',
        ];
    }
}
