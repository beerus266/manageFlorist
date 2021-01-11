<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Models\ImportFlower;
use Carbon\Carbon;

class ImportFlowerController extends Controller
{
    public function __construct(
        FlowerController $FlowerController,
        CustomerController $CustomerController
    ){
        $this->middleware('auth');
        $this->flowerContr = $FlowerController;
        $this->customerContr = $CustomerController;
        $this->subDaysLunar = 43;
    }

    public function index(){

        $dataAllFlower      = $this->flowerContr->getAllFlower();
        $dataAllCustomer    = $this->customerContr->getAllCustomer();
    
        $dataAllImport      = $this->getAllImport();
        // dd($dataAllFlower);
        return view('ImportFlower.index', compact( 'dataAllFlower', 'dataAllCustomer','dataAllImport' ));
    }

    public function StoreImportFlower ( Request $request){
        //dd($request);
        $date           = $request->date;

        foreach ( $request->importFlower as $block ){

            $import = new ImportFlower();

            $import->date           = $date;
            $import->customer_id    = $block['customer_id'];
            $import->flower_id      = $block['flower_id'];
            if( isset($block['note']) ) $import->note = $block['note'];
            $import->tai            = $block['tai'];
            $import->quantity       = $block['quantity'];
            $import->price          = $block['price'];

            $import->save();
        }

        // dd(importFlower::all());

        return response([
            'status' => 'success'
        ]);
    }

    public function StatisticImportFlower ( Request $request ){
        // dd($request);

        $data = ImportFlower::whereBetween('date', [ $request->from, $request->to])
                            ->where('customer_id', $request->customer_id)
                            ->join('flower', 'import_flower.flower_id', '=', 'flower.id')
                            // ->join(' customer ', 'import_flower.customer_id', '=', 'customer.id')
                            ->select('flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date','note')
                            ->orderBy('date','asc')
                            ->get();

        // dd($data);
        return response([
            'data' => $data
        ]);
    }

    function getAllImport(){
        $dataOrigin = ImportFlower::join( 'flower', 'import_flower.flower_id', '=' , 'flower.id')
                                    ->join( 'customer', 'import_flower.customer_id', '=', 'customer.id' )
                                    ->orderBy ('date', 'desc')
                                    ->select('import_flower.id','customer.name', 'flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date','note')
                                    ->limit(500)
                                    ->get();

        // dd($dataOrigin);

        return $dataOrigin;
    }

    public function getBarChart(){
        $current = Carbon::now()->subDays($this->subDaysLunar);
        $curentSubAWeek = Carbon::now()->subDays($this->subDaysLunar + 7);

        $data = ImportFlower::whereBetween('date', [ $curentSubAWeek->toDateString(), $current->toDateString() ])
                            ->groupBy("date")
                            ->select("date",ImportFlower::raw('sum(cast(price as int) * cast(quantity as int)) as total'))
                            ->get();
        return $data;
    }

    function getAmountAMonth(){
        $startOfMonth = Carbon::now()->subDays($this->subDaysLunar)->startOfMonth();
        $endOfMonth = Carbon::now()->subDays($this->subDaysLunar)->endOfMonth();

        $data = ImportFlower::whereBetween('date', [ $startOfMonth, $endOfMonth ])
                            // ->groupBy("date")
                            ->select(ImportFlower::raw('sum(cast(price as int) * cast(quantity as int)) as totalAMonth'))
                            ->get();
        $data[0]->totalAMonth = number_format($data[0]->totalAMonth , 0, '.', ',');
        $data[0]->month = Carbon::now()->subDays($this->subDaysLunar)->month;
        // dd($data);
        return $data;
    }
}
