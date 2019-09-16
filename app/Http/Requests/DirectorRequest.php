<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DirectorRequest
 * @package App\Http\Requests
 */
class DirectorRequest extends FormRequest
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
            'name'          => 'required|max:100',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'date_of_death' => 'nullable|date_format:Y-m-d',
            'oscar'         => 'required|numeric|min:0|max:100'
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
            'name.required'             => 'O nome do diretor é obrigatório!',
            'name.max'                  => 'O nome do diretor deve ter até 100 letras',
            'date_of_birth.required'    => 'A data de nascimento é obrigatória',
            'date_of_birth.date_format' => 'Formato de data inválido para data de nascimento',
            'date_of_death.date_format' => 'Formato de data inválido para data de falescimento',
            'oscar.required'            => 'Quantidade de Oscar é obrigatório',
            'oscar.numeric'             => 'Quantidade de Oscar tem que ser numérico',
            'oscar.min'                 => 'Quantidade de Oscar tem que ser no minímo 0',
            'oscar.max'                 => 'Quantidade de Oscar tem que ser no máximo 100'
        ];
    }
}
