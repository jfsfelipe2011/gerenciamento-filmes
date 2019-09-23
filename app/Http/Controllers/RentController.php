<?php

namespace App\Http\Controllers;

use App\Film;
use App\Http\Requests\RentRequest;
use App\Rent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class RentController
 * @package App\Http\Controllers
 */
class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $rents = Rent::paginate(10);

            Log::channel('app')->info(sprintf('Carregado %s alugueis da base de dados', count($rents)));
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os alugueis',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de alugueis');
        }

        return view('rents.index', compact('rents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentRequest $request)
    {
        $data = $request->all();

        try {
            $films = Film::find($data['films']);

            if (!$films) {
                throw new \Exception('Filme(s) informado não existem');
            }

            DB::beginTransaction();

            $value = 0;
            foreach ($films as $film) {
                $stock = $film->stock;

                if ($stock->quantity === 0) {
                    return redirect()
                        ->route('rents.index')
                        ->with('errors', 'Filme escolhido não está disponível para aluguel');
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
            Log::channel('app')->info('Aluguel criado com sucesso', ['rent' => $rent]);
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao criar um novo aluguel',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('rents.index')
                ->with('errors', 'Não foi possível criar um novo aluguel');
        }

        return redirect()
            ->route('rents.index')
            ->with('success', 'Aluguel criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!($rent = Rent::find($id))) {
            return back()
                ->with('errors', 'Aluguel não encontrado');
        }

        Log::channel('app')->info('Aluguel carregado com sucesso', ['aluguel' => $rent]);

        return view('rents.show', compact('rent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Não será usado
        return redirect()
            ->route('rents.index')
            ->with('error', 'Página não disponível');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RentRequest $request, $id)
    {
        //Não será usado
        return redirect()
            ->route('rents.index')
            ->with('error', 'Página não disponível');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Não será usado
        return redirect()
            ->route('rents.index')
            ->with('error', 'Página não disponível');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        if (!($rent = Rent::find($id))) {
            return back()
                ->with('errors', 'Aluguel não encontrado');
        }

        Log::channel('app')->info('Aluguel carregado com sucesso', ['aluguel' => $rent]);

        try {
            DB::beginTransaction();

            $rent->status = Rent::STATUS_CANCELED;
            $rent->save();

            Log::channel('app')->info('Aluguel cancelado com sucesso', ['aluguel' => $rent]);

            foreach ($rent->films as $film) {
                $stock = $film->stock;
                $stock->quantity += 1;
                $stock->save();

                Log::channel('app')->info('Estoque atualizado com sucesso', 
                    [
                        'estoque'    => $stock, 
                        'quantidade' => $stock->quantity
                    ]
                );
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao cancelar um novo aluguel',
                [
                    'aluguel' => $rent,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('rents.index')
                ->with('errors', 'Não foi possível cancelar o aluguel');
        }
        

        return redirect()
            ->route('rents.index')
            ->with('success', 'Aluguel cancelado com sucesso!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish($id)
    {
        if (!($rent = Rent::find($id))) {
            return back()
                ->with('errors', 'Aluguel não encontrado');
        }

        Log::channel('app')->info('Aluguel carregado com sucesso', ['aluguel' => $rent]);

        try {
            DB::beginTransaction();

            $rent->status        = Rent::STATUS_FINISHED;
            $rent->delivery_date = (new \DateTime())->format('Y-m-d');
            $rent->save();

            Log::channel('app')->info('Aluguel finalizado com sucesso', ['aluguel' => $rent]);

            foreach ($rent->films as $film) {
                $stock = $film->stock;
                $stock->quantity += 1;
                $stock->save();

                Log::channel('app')->info('Estoque atualizado com sucesso', 
                    [
                        'estoque'    => $stock, 
                        'quantidade' => $stock->quantity
                    ]
                );
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao finalizar um novo aluguel',
                [
                    'aluguel' => $rent,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('rents.index')
                ->with('errors', 'Não foi possível finalizar o aluguel');
        }    

        return redirect()
            ->route('rents.index')
            ->with('success', 'Aluguel encerrado com sucesso!');
    }
}
