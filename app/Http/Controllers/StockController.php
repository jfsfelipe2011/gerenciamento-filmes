<?php

namespace App\Http\Controllers;

use App\Film;
use App\Http\Requests\StockRequest;
use Illuminate\Http\Request;
use App\Stock;
use Illuminate\Support\Facades\Log;

/**
 * Class StockController
 * @package App\Http\Controllers
 */
class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $stocks = Stock::paginate(10);

            Log::channel('app')->info(
                sprintf('Carregado %s estoques da base de dados', count($stocks))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os estoques',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de estoques');
        }

        return view('stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (count(Film::getFilmsNotStock()) === 0) {
            return back()
                ->with('errors', 'Não existe nenhum filme sem estoque');
        }

        return view('stocks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        $data = $request->all();

        try {
            $stock = Stock::create($data);

            Log::channel('app')->info('Estoque criado com sucesso', ['estoque' => $stock]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao criar um novo estoque',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('stocks.index')
                ->with('errors', 'Não foi possível criar um novo estoque');
        }

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Estoque criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Não implementado
        return redirect()
            ->route('stocks.index')
            ->with('error', 'Página não disponível');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!($stock = Stock::find($id))) {
            return back()
                ->with('errors', 'Estoque não encontrado');
        }

        Log::channel('app')->info('Estoque carregado com sucesso', ['estoque' => $stock]);

        return view('stocks.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        if (!($stock = Stock::find($id))) {
            return back()
                ->with('errors', 'Estoque não encontrado');
        }

        Log::channel('app')->info('Estoque carregado com sucesso', ['estoque' => $stock]);

        $data = $request->all();

        try {
            $stock->fill($data);
            $stock->save();

            Log::channel('app')->info('Estoque atualizado com sucesso', ['estoque' => $stock]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao atualizar um estoque',
                [
                    'data'    => $data,
                    'estoque' => $stock,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('stocks.index')
                ->with('errors', 'Não foi possível atualizar estoque');
        }

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Estoque alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($stock = Stock::find($id))) {
            return back()
                ->with('errors', 'Estoque não encontrado');
        }

        Log::channel('app')->info('Estoque carregado com sucesso', ['estoque' => $stock]);

        try {
            $stock->delete();

            Log::channel('app')->info('Estoque deletado com sucesso', ['estoque' => $stock]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao deletar um estoque',
                [
                    'estoque' => $stock,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('stocks.index')
                ->with('errors', 'Não foi possível deletar estoque');
        }

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Estoque excluído com sucesso!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add($id)
    {
        if (!($stock = Stock::find($id))) {
            return back()
                ->with('errors', 'Estoque não encontrado');
        }

        Log::channel('app')->info('Estoque carregado com sucesso', ['estoque' => $stock]);

        return view('stocks.add', compact('stock'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuantity(Request $request, $id)
    {
        if (!($stock = Stock::find($id))) {
            return back()
                ->with('errors', 'Estoque não encontrado');
        }

        Log::channel('app')->info('Estoque carregado com sucesso', ['estoque' => $stock]);

        $quantity = $request->get('quantity');

        try {
            $stock->quantity += $quantity;
            $stock->save();

            Log::channel('app')->info('Estoque atualizado com sucesso', ['estoque' => $stock]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao atualizar um estoque',
                [
                    'data'    => $quantity,
                    'estoque' => $stock,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('stocks.index')
                ->with('errors', 'Não foi possível atualizar estoque');
        }

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Quantidade adicionada com sucesso!');
    }
}
