<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Category;
use Illuminate\Support\Facades\Log;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::paginate(10);

            Log::channel('app')->info(
                sprintf('Carregado %s categorias da base de dados', count($categories))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os categorias',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de categorias');
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try {
            $category = Category::create($data);

            Log::channel('app')->info('Categoria criada com sucesso', ['categoria' => $category]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao criar uma nova categoria',
                [
                    'data' => $data,
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('categories.index')
                ->with('errors', 'Não foi possível criar uma nova categoria');
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
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
            ->route('categories.index')
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
        if (!($category = Category::find($id))) {
            return back()
                ->with('errors', 'Categoria não encontrada');
        }

        Log::channel('app')->info('Categoria carregada com sucesso', ['categoria' => $category]);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (!($category = Category::find($id))) {
            return redirect()
                ->route('categories.index')
                ->with('errors', 'Categoria não encontrada');
        }

        Log::channel('app')->info('Categoria carregada com sucesso', ['categoria' => $category]);

        $data = $request->all();

        try {
            $category->fill($data);
            $category->save();

            Log::channel('app')->info('Categoria atualizada com sucesso', ['categoria' => $category]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao atualizar uma categoria',
                [
                    'data'      => $data,
                    'categoria' => $category,
                    'erro'      => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('categories.index')
                ->with('errors', 'Não foi possível atualizar categoria');
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria alterada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!($category = Category::find($id))) {
            return back()
                ->with('errors', 'Categoria não encontrada');
        }

        Log::channel('app')->info('Categoria carregada com sucesso', ['categoria' => $category]);

        try {
            $category->delete();

            Log::channel('app')->info('Categoria deletada com sucesso', ['categoria' => $category]);
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Erro ao deletar uma categoria',
                [
                    'categoria' => $category,
                    'erro'      => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('categories.index')
                ->with('errors', 'Não foi possível deletar categoria');
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
