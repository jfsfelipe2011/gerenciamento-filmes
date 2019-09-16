<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StockRequest
 * @package App\Http\Requests
 */
class StockRequest extends FormRequest
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
            'value'    => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
            'film_id'  => 'required|numeric'
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
            'value.required'    => 'O valor é obrigatório!',
            'value.numeric'     => 'O valor deve ser um número',
            'value.min'         => 'O valor deve ser no mínimo R$ 0',
            'quantity.required' => 'A quantidade é obrigatório!',
            'quantity.numeric'  => 'A quantidade deve ser um número',
            'quantity.min'      => 'A quantidade deve ser no mínimo 1',
            'film_id.required'  => 'É necessário escolher um filme',
            'film_id.numeric'   => 'O filme deve ser um número'
        ];
    }
}
