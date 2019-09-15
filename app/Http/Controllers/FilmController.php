<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Director;
use App\Http\Requests\FilmRequest;
use App\Stock;
use Illuminate\Support\Facades\Storage;
use App\Film;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::paginate(10);

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

        $actors    = Actor::find($data['actors']);
        $directors = Director::find($data['directors']);

        unset($data['actors']);
        unset($data['directors']);

        if (isset($data['image'])) {
            $path = Storage::putFile('films', $request->file('image'));
            $data['image'] = $path;
        }

        DB::transaction(function () use ($data, $actors, $directors) {
            $film = Film::create($data);
            $film->actors()->attach($actors);
            $film->directors()->attach($directors);
        });

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

        $data = $request->all();

        $actors    = Actor::find($data['actors']);
        $directors = Director::find($data['directors']);

        unset($data['actors']);
        unset($data['directors']);

        if (isset($data['image'])) {
            $path = Storage::putFile('films', $request->file('image'));
            $data['image'] = $path;
        }

        DB::transaction(function () use ($film, $data, $actors, $directors) {
            $film->fill($data);
            $film->save();
            $film->actors()->sync($actors);
            $film->directors()->sync($directors);
        });


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

        if ($film->stock instanceof Stock) {
            return back()
                ->with('errors', 'Esse filme tem um estoque, não pode ser excluído');
        }

        if (count($film->rents) > 0) {
            return back()
                ->with('errors', 'Esse filme tem operações de aluguel e não pode ser excluído');
        }

        DB::transaction(function () use ($film) {
            $film->actors()->detach();
            $film->directors()->detach();
            $film->delete();
        });

        return redirect()
            ->route('films.index')
            ->with('success', 'Filme excluído com sucesso!');
    }
}
