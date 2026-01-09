<?php

namespace App\Http\Requests\review;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends ApiFormRequest
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
            'rating' => 'required|integer|max:5|min:1',
            'comment' => 'string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'El raiting es obligatorio',
            'rating.integer' => 'El raiting debe de ser un valor numerico',
            'rating.max' => 'El rating no puede superar los cinco puntos',
            'rating.min' => 'El rating debe tener al menos un puntos',
            'comment.string' => 'El comentario debe de ser una cadena de texto',
            'comment.max' => 'El comentario no puede superar los cien caracteres',
        ];
    }
}
