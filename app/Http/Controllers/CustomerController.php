<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{

    public function __construct(

    ){
        $this->middleware('auth');
    }
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
        $customer->isImporter     = $request->isImporter;

        $customer->save();

        $data = Customer::latest()->first();

        // dd($data->created_at);

        return response([
            'data' => $data,
        ]);
    }

    function getAllCustomerImport(){

        return Customer::where("isImporter",1)->orWhere("isImporter",2)->orderBy('name','asc')->get();
    }

    function getAllCustomerExport(){

        return Customer::where("isImporter",0)->orWhere("isImporter",2)->orderBy('name','asc')->get();
    }

    function getAllCustomer(){

        return Customer::orderBy('name','asc')->get();
    }

    function countAllCustomer(){
        return CusTomer::all()->count();
    }
}
