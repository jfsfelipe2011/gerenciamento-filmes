<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Category;
use Illuminate\Support\Facades\Log;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();

            Log::channel('api')->info(
                sprintf('Carregado %s categorias da base de dados', count($categories))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os categorias',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao carregar categorias');
        }

        return response()->json($categories, 200);
    }

    /**
     * @param $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $category = Category::where('id', $id)->first();
        } catch (\Throwable $exception){
            Log::channel('error')->critical('Não foi possível carregar a categoria',
                [
                    'erro' => $exception->getMessage(),
                    'id'   => $id
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao carregar categoria');
        }

        if (!$category instanceof Category) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }

        Log::channel('api')->info('Carregada categoria #{id} da base de dados',
            [
                'id'       => $category->id,
                'category' => $category
            ]
        );

        return response()->json($category, 200);
    }
}
