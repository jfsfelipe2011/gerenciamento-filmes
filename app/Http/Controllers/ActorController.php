<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActorRequest;
use Illuminate\Support\Facades\Log;
use App\Actor;

/**
 * Class ActorController
 * @package App\Http\Controllers
 */
class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $actors = Actor::paginate(10);

            Log::channel('app')->info(sprintf('Carregado %s atores da base de dados', count($actors)));
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os atores',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de atores');
        }

        return view('actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('actors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        $data = $request->all();

        try {
            $actor = Actor::create($data);

            Log::channel('app')->info('Ator criado com sucesso', ['ator' => $actor]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao criar um novo ator',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('actors.index')
                ->with('errors', 'Não foi possível criar um novo ator');
        }

        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator criado com sucesso!');
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
            ->route('actors.index')
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
        if (!($actor = Actor::find($id))) {
            return back()
                ->with('errors', 'Ator não encontrado');
        }

        Log::channel('app')->info('Ator carregado com sucesso', ['ator' => $actor]);

        return view('actors.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, $id)
    {
        if (!($actor = Actor::find($id))) {
            return redirect()
                ->route('actors.index')
                ->with('errors', 'Ator não encontrado');
        }

        Log::channel('app')->info('Ator carregado com sucesso', ['ator' => $actor]);

        $data = $request->all();

        try {
            $actor->fill($data);
            $actor->save();

            Log::channel('app')->info('Ator atualizado com sucesso', ['ator' => $actor]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao atualizar um ator',
                [
                    'data' => $data,
                    'ator' => $actor,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('actors.index')
                ->with('errors', 'Não foi possível atualizar ator');
        }

        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($actor = Actor::find($id))) {
            return back()
                ->with('errors', 'Ator não encontrado');
        }

        Log::channel('app')->info('Ator carregado com sucesso', ['ator' => $actor]);

        try {
            $actor->delete();

            Log::channel('app')->info('Ator deletado com sucesso', ['ator' => $actor]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao deletar um ator',
                [
                    'ator' => $actor,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('actors.index')
                ->with('errors', 'Não foi possível deletar ator');
        }

        return redirect()
            ->route('actors.index')
            ->with('success', 'Ator excluído com sucesso!');
    }
}
