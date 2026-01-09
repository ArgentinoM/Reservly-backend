<?php

namespace App\Http\Requests;

class PaginateRequest extends ApiFormRequest
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
            'page' => 'integer|required',
            'perPage' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'El valor page debe de ser un valor numerico',
            'page.required' => 'El valor page es obligatorio',
            'perPage.integer' => 'El valor perPage debe de ser un valor numerico',
        ];
    }
}
