<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\Log;

/**
 * Class CustomerController
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customers = Customer::paginate(10);

            Log::channel('app')->info(
                sprintf('Carregado %s clientes da base de dados', count($customers))
            );
        } catch (\Throwable $exception) {
            Log::channel('error')->critical('Não foi possível carregar os clientes',
                [
                    'erro' => $exception->getMessage()
                ]
            );

            return redirect()
                ->route('home')
                ->with('errors', 'Não foi possível acessar a página de clientes');
        }

        return view('customers.index', compact('customers'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showRents($id)
    {
        if (!($customer = Customer::find($id))) {
            return back()
                ->with('errors', 'Cliente não encontrado');
        }

        Log::channel('app')->info('Cliente carregado com sucesso', ['cliente' => $customer]);

        $rents = $customer->rents()->paginate(10);

        Log::channel('app')->info(
            sprintf('Carregado %s alugueis da base de dados', count($rents))
        );

        return view('customers.rents', compact('rents', 'customer'));
    }
}
