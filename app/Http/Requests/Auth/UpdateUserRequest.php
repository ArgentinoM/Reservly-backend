<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class UpdateUserRequest extends ApiFormRequest
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
            'img_perfil' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'name' => 'string|max:50',
            'surname' => 'string|max:100',
            'phone' => 'nullable|string|min:10|max:10|unique:users,phone,' . $this->user()->id,
            'bio' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'img_perfil.image' => 'El archivo debe ser una imagen (jpeg, png, jpg, gif, webp).',
            'img_perfil.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp o gif.',
            'img_perfil.max' => 'La imagen no debe superar los 5 MB.',
            'name.string' => 'El nombre debe de ser una cadena de texto',
            'name.max' => 'El nombre no debe superar los 50 caracteres',
            'surname.string' => 'Los apellido deben de ser una cadena de texto',
            'surname.max' => 'Los apellidos no deben superar los 100 caracteres',
            'phone.string' => 'El telefono debe de ser una cadena de texto',
            'phone.min' => 'El telefono debe tener al menos 10 caracteres',
            'phone.max' => 'El telefono no debe superar los 10 caracteres',
            'phone.unique' => 'El telefono ya esta en uso en una cuenta diferente',
            'bio.string' => 'La biografia debe de ser una cadena de texto',
            'bio.max' => 'La biografia no debe superar los 255 caracteres',
        ];
    }
}
