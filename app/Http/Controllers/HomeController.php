<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExportFlower;
use App\Models\ImportFlower;
use App\Models\Flower;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportFlowerController;
use App\Http\Controllers\ImportFlowerController;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct(
        FlowerController $FlowerController,
        CustomerController $CustomerController,
        ExportFlowerController $ExportFlowerController,
        ImportFlowerController $ImportFlowerController
    ){
        $this->middleware('auth');
        $this->flowerContr = $FlowerController;
        $this->customerContr = $CustomerController;
        $this->exportContr = $ExportFlowerController;
        $this->importContr = $ImportFlowerController;
    }

    public function index(){
        
        $countFlower = $this->flowerContr->countAllFlower();
        $countCustomer = $this->customerContr->countAllCustomer();
        $amountExportAMonth = $this->exportContr->getAmountAMonth()[0];
        $amountImportAMonth = $this->importContr->getAmountAMonth()[0];

        return view('Home.index',compact('countFlower','countCustomer','amountExportAMonth','amountImportAMonth'));
    } 

    public function getBarChart(){

        $dataEx = $this->exportContr->getBarChart();
        $dataIm = $this->importContr->getBarChart();
        return response([
            'dataEx' => $dataEx,
            'dataIm' => $dataIm
        ]);
    }

    public function getQuantityEachFlowerByDate(Request $request){

        // dd($request->date);

        $date = $request->date;

        $data = Flower::leftJoin('import_flower',function($join) use($date){
                            $join->on('import_flower.flower_id','=','flower.id')
                                    ->where('import_flower.date',$date);
                        })
                        ->leftJoin('export_flower',function($join) use($date){
                            $join->on('export_flower.flower_id','=','flower.id')
                                    ->where('export_flower.date',$date);
                        })
                        ->groupBy('import_flower.flower_id','export_flower.flower_id','flower.flower_name')
                        ->whereNotNull('import_flower.flower_id')
                        ->orWhereNotNull('export_flower.flower_id')
                        ->selectRaw('flower.flower_name,  SUM(cast(import_flower.quantity as int)) as quantityIm, SUM(cast(export_flower.quantity as int)) as quantityEx')
                        ->get();
        // dd($data);

        return response([
            'data' => $data
        ]);
    }
}
