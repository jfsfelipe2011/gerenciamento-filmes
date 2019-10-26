<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Film;

/**
 * Class FilmController
 * @package App\Http\Controllers\Api
 */
class FilmController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Film();

        $order = $request->all()['order'] ?? null;

        if (!is_null($order)) {
            $order = explode(',', $order);
        }

        $order[0] = $order[0] ?? 'id';
        $order[1] = $order[1] ?? 'asc';

        $filter = $request->all()['filter'] ?? null;

        if (!is_null($filter)) {
            $filter = explode(',', $filter);
        }

        try {
            $result = $model->orderBy($order[0], $order[1])
                ->where($filter[0], $filter[1])
                ->with(['category', 'actors', 'directors', 'stock'])
                ->get();

            Log::channel('api')->info(
                sprintf('Carregado %s filmes da base de dados', count($result))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os filmes',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao carregar filmes');
        }

        return response()->json($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $film = (new Film())
                ->where('id', (int) $id)
                ->with(['category', 'actors', 'directors', 'stock'])
                ->first();
        } catch (\Throwable $exception){
            Log::channel('error')->critical('Não foi possível carregar o filme',
                [
                    'erro'     => $exception->getMessage(),
                    'id'       => $id
                ]
            );

            return $this->sendResponseStatus(false, 400, 'Erro ao carregar filme');
        }

        if (!$film instanceof Film) {
            return response()->json(['error' => 'Filme não encontrado'], 404);
        }

        Log::channel('api')->info('Carregado filme #{id} da base de dados',
            [
                'id'      => $id,
                'filme'   => $film
            ]
        );

        return response()->json($film, 200);
    }
}
