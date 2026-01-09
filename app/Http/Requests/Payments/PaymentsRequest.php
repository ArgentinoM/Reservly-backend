<?php

namespace App\Http\Requests\Payments;

use App\Http\Requests\ApiFormRequest;

class PaymentsRequest extends ApiFormRequest
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
            'service_id' => 'required|integer|exists:services,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'Debes seleccionar un servicio para pagar.',
            'service_id.integer' => 'El ID del servicio debe ser un número válido.',
            'service_id.exists' => 'El servicio seleccionado no existe.',
            'start_date.required' => 'Debes indicar la fecha de inicio de la reservación.',
            'start_date.date' => 'La fecha de inicio no es válida.',
            'end_date.required' => 'Debes indicar la fecha de fin de la reservación.',
            'end_date.date' => 'La fecha de fin no es válida.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    }
}
