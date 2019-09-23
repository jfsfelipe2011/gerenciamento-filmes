<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Director;
use App\Http\Requests\FilmRequest;
use App\Stock;
use Illuminate\Support\Facades\Storage;
use App\Film;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class FilmController
 * @package App\Http\Controllers
 */
class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $films = Film::paginate(10);

            Log::channel('app')->info(sprintf('Carregado %s filmes da base de dados', count($films)));
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os filmes',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de filmes');
        }

        return view('films.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('films.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {
        $data = $request->all();

        try {
            $actors    = Actor::find($data['actors']);
            $directors = Director::find($data['directors']);

            if (!$actors || !$directors) {
                throw new \Exception('Não encontrado os atores ou diretores informados');
            }

            unset($data['actors']);
            unset($data['directors']);

            if (isset($data['image'])) {
                $path = Storage::putFile('films', $request->file('image'));
                $data['image'] = $path;
            }

            DB::beginTransaction();
            
            $film = Film::create($data);
            $film->actors()->attach($actors);
            $film->directors()->attach($directors);

            DB::commit();
            Log::channel('app')->info('Filme criado com sucesso', ['filme' => $film]);
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao criar um novo filme',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('films.index')
                ->with('errors', 'Não foi possível criar um novo filme');
        }

        return redirect()
            ->route('films.index')
            ->with('success', 'Filme criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!($film = Film::find($id))) {
            return back()
                ->with('errors', 'Filme não encontrado');
        }

        Log::channel('app')->info('Filme carregado com sucesso', ['filme' => $film]);

        return view('films.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!($film = Film::find($id))) {
            return back()
                ->with('errors', 'Filme não encontrado');
        }

        Log::channel('app')->info('Filme carregado com sucesso', ['filme' => $film]);

        return view('films.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilmRequest $request, $id)
    {
        if (!($film = Film::find($id))) {
            return back()
                ->with('errors', 'Filme não encontrado');
        }

        Log::channel('app')->info('Filme carregado com sucesso', ['filme' => $film]);

        $data = $request->all();

        try {
            $actors    = Actor::find($data['actors']);
            $directors = Director::find($data['directors']);

            if (!$actors || !$directors) {
                throw new \Exception('Não encontrado os atores ou diretores informados');
            }

            unset($data['actors']);
            unset($data['directors']);

            if (isset($data['image'])) {
                $path = Storage::putFile('films', $request->file('image'));
                $data['image'] = $path;
            }

            DB::beginTransaction();

            $film->fill($data);
            $film->save();
            $film->actors()->sync($actors);
            $film->directors()->sync($directors);

            DB::commit();
            Log::channel('app')->info('Filme atualizado com sucesso', ['filme' => $film]);
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao atualizar um filme',
                [
                    'data'  => $data,
                    'filme' => $film,
                    'erro'  => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('films.index')
                ->with('errors', 'Não foi possível atualizar o filme');
        }


        return redirect()
            ->route('films.index')
            ->with('success', 'Filme alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($film = Film::find($id))) {
            return back()
                ->with('errors', 'Filme não encontrado');
        }

        Log::channel('app')->info('Filme carregado com sucesso', ['filme' => $film]);

        if ($film->stock instanceof Stock) {
            return back()
                ->with('errors', 'Esse filme tem um estoque, não pode ser excluído');
        }

        if (count($film->rents) > 0) {
            return back()
                ->with('errors', 'Esse filme tem operações de aluguel e não pode ser excluído');
        }

        try {
            DB::beginTransaction();

            $film->actors()->detach();
            $film->directors()->detach();
            $film->delete();

            DB::commit();
            Log::channel('app')->info('Filme excluído com sucesso', ['filme' => $film]);
        } catch (\Throwable $exception) {
            DB::rollback();

            Log::channel('error')->critical('Erro ao excluir um filme',
                [
                    'filme' => $film,
                    'erro'  => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('films.index')
                ->with('errors', 'Não foi possível excluir o filme');
        }
        

        return redirect()
            ->route('films.index')
            ->with('success', 'Filme excluído com sucesso!');
    }
}
