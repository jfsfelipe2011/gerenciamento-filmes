<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date'    => 'required|date_format:Y-m-d',
            'end_date'      => 'required|date_format:Y-m-d',
            'customer_id'   => 'required|numeric',
            'films'         => 'required|array'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_date.required'    => 'A data de inicio é obrigatória',
            'start_date.date_format' => 'Formato de data inválido para data de inicio',
            'end_date.required'      => 'A data de fim é obrigatória',
            'end_date.date_format'   => 'Formato de data inválido para data de fim',
            'customer.required'      => 'Cliente é obrigatório',
            'customer.numeric'       => 'Cliente deve ser um número',
            'films.required'         => 'É necessário escolher os filmes',
            'films.array'            => 'Filmes devem ser um array'
        ];
    }
}
