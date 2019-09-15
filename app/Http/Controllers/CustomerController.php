<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

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
