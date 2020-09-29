<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Models\ExportFlower;

class ExportFlowerController extends Controller
{
    
    public function __construct(
        FlowerController $FlowerController,
        CustomerController $CustomerController
    ){
        $this->flowerContr = $FlowerController;
        $this->customerContr = $CustomerController;
    }

    public function index(){

        $dataAllFlower      = $this->flowerContr->getAllFlower();
        $dataAllCustomer    = $this->customerContr->getAllCustomer();
    
        $dataAllExport      = $this->getAllExport();
        // dd($dataAllExport);
        return view('ExportFlower.index', compact( 'dataAllFlower', 'dataAllCustomer','dataAllExport' ));
    }

    public function StoreExportFlower ( Request $request){
        // dd($request);

        $date           = $request->date;

        foreach ( $request->exportFlower as $block ){

            $export = new ExportFlower();

            $export->date           = $date;
            $export->customer_id    = $block['customer_id'];
            $export->flower_id      = $block['flower_id'];
            $export->tai            = $block['tai'];
            $export->quantity       = $block['quantity'];
            $export->price          = $block['price'];

            $export->save();
        }

        // dd(ExportFlower::all());

        return response([
            'status' => 'success'
        ]);
    }

    public function StatisticExportFlower ( Request $request ){

        // dd($request);

        $data = ExportFlower::whereBetween('date', [ $request->from, $request->to])
                            ->where('customer_id', $request->customer_id)
                            ->join('flower', 'export_flower.flower_id', '=', 'flower.id')
                            // ->join(' customer ', 'export_flower.customer_id', '=', 'customer.id')
                            ->select('flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date')
                            ->orderBy('date','asc')
                            ->get();

        // dd($data);
        return response([
            'data' => $data
        ]);
    }

    function getAllExport(){

        $dataOrigin = ExportFlower::join( 'flower', 'export_flower.flower_id', '=' , 'flower.id')
                                    ->join( 'customer', 'export_flower.customer_id', '=', 'customer.id' )
                                    ->orderBy ('date', 'asc')
                                    ->select('export_flower.id','customer.name', 'flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date')
                                    ->get();

        // dd($dataOrigin);

        return $dataOrigin;
    }
}
