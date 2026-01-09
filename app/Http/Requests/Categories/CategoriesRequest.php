<?php

namespace App\Http\Requests\categories;

use App\Http\Requests\ApiFormRequest;

class CategoriesRequest extends ApiFormRequest
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
            'name' => 'required|string|max:50|unique:category_services',
            'desc' => 'string|max:200'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El nombre debe de ser unico',
            'name.string' => 'El nombre debe de ser una cadena de texto',
            'name.max' => 'El nombre no debe superar los 50 caracteres',
            'desc.string' => 'La descrición debe de ser una cadena de texto',
            'desc.max' => 'La descripción no debe superar los 200 caracteres',
        ];
    }
}
