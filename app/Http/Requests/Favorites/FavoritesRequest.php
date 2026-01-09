<?php

namespace App\Http\Requests\Favorites;

use App\Http\Requests\ApiFormRequest;

class FavoritesRequest extends ApiFormRequest
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
            'service_id' => 'required|integer|exists:services,id|unique:favorites'
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'El servicio es obligatorio',
            'service_id.integer' => 'El id del servicio debe de ser un valor numerico',
            'service_id.exists' => 'El servicio no esta registrado',
            'service_id.unique' => 'Ya has agregado a favoritos ese servicio'
        ];
    }
}
