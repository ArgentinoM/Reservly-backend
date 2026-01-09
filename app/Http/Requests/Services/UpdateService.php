<?php

namespace App\Http\Requests\Services;

use App\Http\Requests\ApiFormRequest;

class UpdateService extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:50|unique:services',
            'desc' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:200',
            'duration' => 'sometimes|integer|max:24',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category_id' => 'sometimes|integer|exists:category_services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'El nombre debe de ser único',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no debe superar los 50 caracteres',
            'desc.string' => 'La descripción debe ser una cadena de texto',
            'desc.max' => 'La descripción no debe superar los 255 caracteres',
            'price.numeric' => 'El precio debe ser un valor numérico',
            'price.min' => 'El precio no puede ser menor a 200',
            'duration.integer' => 'La duración debe ser un valor numérico',
            'duration.max' => 'La duración no debe ser superior a 24',
            'img.image' => 'El archivo debe ser una imagen (jpeg, png, jpg, gif, webp).',
            'img.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp o gif.',
            'img.max' => 'La imagen no debe superar los 5 MB.',
            'category_id.exists' => 'La categoría no existe',
            'category_id.integer' => 'La categoría debe ser un valor numérico',
        ];
    }
}
