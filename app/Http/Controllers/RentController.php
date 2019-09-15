<?php

namespace App\Http\Controllers;

use App\Film;
use App\Http\Requests\RentRequest;
use Illuminate\Http\Request;
use App\Rent;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = Rent::paginate(10);

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
        $films = Film::find($data['films']);

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

            $value += $stock->value;
        }

        $data['value']  = $value;
        $data['status'] = Rent::STATUS_RENTED;

        $rent = Rent::create($data);
        $rent->films()->attach($films);

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
    }

    public function cancel($id)
    {
        if (!($rent = Rent::find($id))) {
            return back()
                ->with('errors', 'Aluguel não encontrado');
        }

        $rent->status = Rent::STATUS_CANCELED;
        $rent->save();

        foreach ($rent->films as $film) {
            $stock = $film->stock;
            $stock->quantity += 1;
            $stock->save();
        }

        return redirect()
            ->route('rents.index')
            ->with('success', 'Aluguel cancelado com sucesso!');
    }

    public function finish($id)
    {
        if (!($rent = Rent::find($id))) {
            return back()
                ->with('errors', 'Aluguel não encontrado');
        }

        $rent->status        = Rent::STATUS_FINISHED;
        $rent->delivery_date = (new \DateTime())->format('Y-m-d');
        $rent->save();

        foreach ($rent->films as $film) {
            $stock = $film->stock;
            $stock->quantity += 1;
            $stock->save();
        }

        return redirect()
            ->route('rents.index')
            ->with('success', 'Aluguel encerrado com sucesso!');
    }
}
