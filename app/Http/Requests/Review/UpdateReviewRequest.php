<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\ApiFormRequest;

class UpdateReviewRequest extends ApiFormRequest
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
            'comment' => 'string|max:100|required',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'El comentario es requerido',
            'comment.string' => 'El comentario debe de ser una cadena de texto',
            'comment.max' => 'El comentario no puede superar los cien caracteres',
        ];
    }
}
