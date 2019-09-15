<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::paginate(10);

        return view('stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        Stock::create($data);

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

        $data = $request->all();

        $stock->fill($data);
        $stock->save();

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

        $stock->delete();
        return redirect()
            ->route('stocks.index')
            ->with('success', 'Estoque excluído com sucesso!');
    }
}