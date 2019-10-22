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
}
