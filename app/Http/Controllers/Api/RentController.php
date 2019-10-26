<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Film;
use App\Http\Requests\RentRequest;
use App\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RentController extends BaseApiController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validation = $this->validateRent($data);

            if ($validation->fails()) {
                return $this->sendErrors($validation->errors());
            }

            $films = Film::find($data['films']);

            if (count($films) === 0) {
                throw new \Exception('Filme(s) informado não existem');
            }

            $customer = Customer::find($data['customer_id']);

            if (!$customer) {
                throw new \Exception('Cliente informado não existe');
            }

            DB::beginTransaction();

            $value = 0;
            foreach ($films as $film) {
                $stock = $film->stock;

                if ($stock->quantity === 0) {
                    throw new \Exception('O filme não está disponível para aluguel');
                }

                $stock->quantity -= 1;
                $stock->save();

                Log::channel('app')->info('Estoque atualizado com sucesso',
                    [
                        'estoque'    => $stock,
                        'quantidade' => $stock->quantity
                    ]
                );

                $value += $stock->value;
            }

            $data['value']  = $value;
            $data['status'] = Rent::STATUS_RENTED;

            $rent = Rent::create($data);
            $rent->films()->attach($films);

            DB::commit();

            if ($rent instanceof Rent) {
                Log::channel('api')->info('Criado novo aluguel com sucesso',
                    [
                        'aluguel' => $rent
                    ]
                );
            }

            return response()->json($rent, 201);
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Não foi possível criar um novo aluguel',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao criar aluguel');
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateRent($data)
    {
        $rentRequest = new RentRequest();

        return Validator::make($data, $rentRequest->rules(), $rentRequest->messages());
    }
}
