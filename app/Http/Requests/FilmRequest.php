<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FilmRequest
 * @package App\Http\Requests
 */
class FilmRequest extends FormRequest
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
            'name'         => 'required|max:100',
            'description'  => 'required',
            'duration'     => 'required|numeric|min:10',
            'release_date' => 'required|date_format:Y-m-d',
            'category_id'  => 'required|numeric',
            'actors'       => 'required|array',
            'directors'    => 'required|array'
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
            'name.required'             => 'O nome do filme é obrigatório',
            'name.max'                  => 'O nome do filme deve ter até 100 letras',
            'description.required'      => 'A descrição é obrigatória',
            'duration.required'         => 'A duração é obrigatório',
            'duration.numeric'          => 'Duração tem que ser numérico',
            'duration.min'              => 'Duração de um filme é no mínimo 10 mim',
            'release_date.required'     => 'A data de lançamento é obrigatória',
            'date_of_birth.date_format' => 'Formato de data inválido para data de lançamento',
            'category_id.required'      => 'É necessário selecionar uma categoria de filme',
            'category_id.numeric'       => 'Categoria deve ser um númerico',
            'actors.required'           => 'É necessário informar um elenco para o filme',
            'actors.array'              => 'O elenco deve ser um array',
            'directors.required'        => 'É necessário informar um ou mais diretores para o filme',
            'directors.array'           => 'Os diretores devem ser um array'
        ];
    }
}
