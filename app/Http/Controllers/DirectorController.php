<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectorRequest;
use App\Director;
use Illuminate\Support\Facades\Log;

/**
 * Class DirectorController
 * @package App\Http\Controllers
 */
class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $directors = Director::paginate(10);

            Log::channel('app')->info(
                sprintf('Carregado %s diretores da base de dados', count($directors))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os diretores',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de diretores');
        }

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

        try {
            $director = Director::create($data);

            Log::channel('app')->info('Diretor criado com sucesso', ['diretor' => $director]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao criar um novo diretor',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('directors.index')
                ->with('errors', 'Não foi possível criar um novo diretor');
        }

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
        return redirect()
            ->route('directors.index')
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
        if (!($director = Director::find($id))) {
            return back()
                ->with('errors', 'Diretor não encontrado');
        }

        Log::channel('app')->info('Diretor carregado com sucesso', ['diretor' => $director]);

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

        Log::channel('app')->info('Diretor carregado com sucesso', ['diretor' => $director]);

        $data = $request->all();

        try {
            $director->fill($data);
            $director->save();

            Log::channel('app')->info('Diretor atualizado com sucesso', ['diretor' => $director]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao atualizar um diretor',
                [
                    'data'    => $data,
                    'diretor' => $director,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('directors.index')
                ->with('errors', 'Não foi possível atualizar diretor');
        }

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

        Log::channel('app')->info('Diretor carregado com sucesso', ['diretor' => $director]);

        try {
            $director->delete();

            Log::channel('app')->info('Diretor deletado com sucesso', ['diretor' => $director]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao deletar um diretor',
                [
                    'diretor' => $director,
                    'erro'    => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('directors.index')
                ->with('errors', 'Não foi possível deletar diretor');
        }

        return redirect()
            ->route('directors.index')
            ->with('success', 'Diretor excluído com sucesso!');
    }
}
