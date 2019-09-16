<?php

namespace App\Http\Controllers;

use App\Customer;

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
        $customers = Customer::paginate(10);

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

        $rents = $customer->rents()->paginate(10);

        return view('customers.rents', compact('rents', 'customer'));
    }
}
