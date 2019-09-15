<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectorRequest;
use App\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directors = Director::paginate(10);

        return view('directors.index', compact('directors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectorRequest $request)
    {
        $data = $request->all();
        Director::create($data);

        return redirect()
            ->route('directors.index')
            ->with('success', 'Diretor criado com sucesso!');
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
        if (!($director = Director::find($id))) {
            return back()
                ->with('errors', 'Diretor não encontrado');
        }

        return view('directors.edit', compact('director'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DirectorRequest $request, $id)
    {
        if (!($director = Director::find($id))) {
            return back()
                ->with('errors', 'Diretor não encontrado');
        }

        $data = $request->all();

        $director->fill($data);
        $director->save();

        return redirect()
            ->route('directors.index')
            ->with('success', 'Diretor alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($director = Director::find($id))) {
            return back()
                ->with('errors', 'Diretor não encontrado');
        }

        $director->delete();
        return redirect()
            ->route('directors.index')
            ->with('success', 'Diretor excluído com sucesso!');
    }
}
