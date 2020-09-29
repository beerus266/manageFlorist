<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
        
        $allCustomer = $this->getAllCustomer();

        // dd($allCustomer);
        return view('Customer.index', compact('allCustomer')); 
    }

    public function StoreCustomer ( Request $request){
        // dd($request);

        $customer = new Customer() ;

        $customer->name           = $request->name;
        $customer->address        = $request->address;
        $customer->phone          = $request->phone;
        $customer->account_bank   = $request->account_bank;

        $customer->save();

        $data = Customer::latest()->first();

        // dd($data->created_at);

        return response([
            'data' => $data,
        ]);
    }

    function getAllCustomer(){

        return Customer::all();
    }
}
