<?php

namespace App\Http\Controllers;

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
        /*$data = $request->all();
        Actor::create($data);

        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator criado com sucesso!');*/
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
        /*if (!($actor = Actor::find($id))) {
            return back()
                ->with('errors', 'Ator não encontrado');
        }

        return view('actors.edit', compact('actor'));*/
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
        /*if (!($actor = Actor::find($id))) {
            return back()
                ->with('errors', 'Ator não encontrado');
        }

        $data = $request->all();

        $actor->fill($data);
        $actor->save();

        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator alterado com sucesso!');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*if (!($actor = Actor::find($id))) {
            return back()
                ->with('errors', 'Ator não encontrado');
        }

        $actor->delete();
        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator excluído com sucesso!');*/
    }
}
