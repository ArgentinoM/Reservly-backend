<?php

namespace App\Http\Requests\Services;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class ServicesRequest extends ApiFormRequest
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
            'name' => 'required|string|max:50|unique:services',
            'desc' => 'required|string|max:255',
            'price' => 'numeric|min:200|required',
            'duration' => 'required|integer|max:24',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category_id' => 'required|integer|exists:category_services,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El nombre debe de ser unico',
            'name.string' => 'El nombre debe de ser una cadena de texto',
            'name.max' => 'El nombre no debe superar los 50 caracteres',
            'desc.required' => 'La descripción es obligatoria',
            'desc.string' => 'La descripción debe de ser una cadena de texto',
            'desc.max' => 'La descripción no debe superar los 50 caracteres',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe de ser un valor numerico',
            'price.min' => 'El precio no puede ser menor a 200',
            'duration.required' => 'La duración es obligatoria',
            'duration.integer' => 'La duración debe de ser un valor numerico',
            'duration.max' => 'La duración no debe ser superior a 24',
            'img.required' => 'La imagen es obligatorio',
            'img.unique' => 'La imagen debe de ser unica',
            'img.image' => 'El archivo debe ser una imagen (jpeg, png, jpg, gif, webp).',
            'img.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp o gif.',
            'img.max' => 'La imagen no debe superar los 5 MB.',
            'category_id.required' => 'La categoria es obligatorio',
            'category_id.exists' => 'La categoria no existe',
            'category_id.integer' => 'La categoria debe de ser un valor numerico',
        ];
    }
}
