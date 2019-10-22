<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Customer;

/**
 * Class CustomerController
 * @package App\Http\Controllers\API
 */
class CustomerController extends BaseApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validation = $this->validateCustomer($data);

            if ($validation->fails()) {
                return $this->sendErrors($validation->errors());
            }

            $customer = Customer::create($data);

            if ($customer instanceof Customer) {
                Log::channel('api')->info('Criado novo cliente com sucesso', 
                    [
                        'cliente' => $customer
                    ]
                );
            }

            return response()->json($customer, 201);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível criar um novo cliente',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao criar cliente');
        }
    }

    public function validateCustomer($data)
    {
        $messages = [
            'name.required'           => 'É obrigatório infomar um nome',
            'name.string'             => 'Nome deve ser informado como caracteres',
            'name.min'                => 'O nome deve ter no mínimo 4 caracteres',
            'name.max'                => 'O nome deve ter no máximo 100 caracteres',
            'address.required'        => 'É obrigatório informar um endereço',
            'address.string'          => 'Endereço dever ser informado como caracteres',
            'document.required'       => 'É obrigatório informar o seu documento',
            'document.numeric'        => 'Documento deve ser um númerico',
            'document.digits_between' => 'Documento deve ter o tamanho de 11 caracteres',
            'payment.required'        => 'É obrigatorio informar uma forma de pagamento',
            'payment.string'          => 'Forma de Pagamento deve ser informado como caracteres',
            'payment.in'              => 'Forma de Pagamento deve ser cartão ou boleto'
        ];

        $rules = [
            'name'     => 'required|string|min:4|max:100',
            'address'  => 'required|string',
            'document' => 'required|numeric|digits_between:11,11',
            'payment'  => [
                'required',
                'string',
                Rule::in(Customer::VALID_PAYMENTS)
            ]
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function show($document)
    {
        try {
            $customer = Customer::where('document', $document)->first();
        } catch (\Throwable $exception){
            Log::channel('error')->critical('Não foi possível carregar o cliente',
                [
                    'erro'     => $exception->getMessage(),
                    'document' => $document
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao carregar cliente');
        }

        if (!$customer instanceof Customer) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        Log::channel('api')->info('Carregado cliente #{id} da base de dados', 
            [
                'id'      => $customer->id,
                'cliente' => $customer
            ]
        );

        return response()->json($customer, 200);
    }
}