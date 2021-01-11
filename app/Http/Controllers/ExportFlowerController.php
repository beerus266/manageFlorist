<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Models\ExportFlower;
use Carbon\Carbon;

class ExportFlowerController extends Controller
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
    
        $dataAllExport      = $this->getAllExport();
        // dd($dataAllFlower);
        return view('ExportFlower.index', compact( 'dataAllFlower', 'dataAllCustomer','dataAllExport' ));
    }

    public function StoreExportFlower ( Request $request){
        //dd($request);
        //$request->file('imgInvoice')->store('InvoiceStorage');

        //dd($request->hasFile('imgInvoice')  );

        // if ($request->hasFile('imgInvoice')) {

        //     $fileInvoice = $request->imgInvoice;
        //     Storage::putFileAs('InvoiceStorage',$fileInvoice,"name.pdf");
        //  //   $file->move('InvoiceStorage', $file->getClientOriginalName());
        //     return back();
        // } else {
        //     return view('welcome');
        // }
        $date           = $request->date;

        foreach ( $request->exportFlower as $block ){

            $export = new ExportFlower();

            $export->date           = $date;
            $export->customer_id    = $block['customer_id'];
            $export->flower_id      = $block['flower_id'];
            if( isset($block['note']) ) $export->note = $block['note'];
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
                            ->select('flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date','note')
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
                                    ->orderBy ('date', 'desc')
                                    ->select('export_flower.id','customer.name', 'flower.flower_name', 'flower.flower_code', 'tai', 'quantity', 'price', 'date','note')
                                    ->limit(500)
                                    ->get();

        // dd($dataOrigin);

        return $dataOrigin;
    }

    public function getBarChart(){
        $current = Carbon::now()->subDays($this->subDaysLunar);
        $curentSubAWeek = Carbon::now()->subDays($this->subDaysLunar + 7);

        $data = ExportFlower::whereBetween('date', [ $curentSubAWeek->toDateString(), $current->toDateString() ])
                            ->groupBy("date")
                            ->select("date",ExportFlower::raw('sum(cast(price as int) * cast(quantity as int)) as total'))
                            ->get();
        return $data;
    }

    function getAmountAMonth(){
        $startOfMonth = Carbon::now()->subDays($this->subDaysLunar)->startOfMonth();
        $endOfMonth = Carbon::now()->subDays($this->subDaysLunar)->endOfMonth();

        $data = ExportFlower::whereBetween('date', [ $startOfMonth, $endOfMonth ])
                            // ->groupBy("date")
                            ->select(ExportFlower::raw('sum(cast(price as int) * cast(quantity as int)) as totalAMonth'))
                            ->get();
        $data[0]->totalAMonth = number_format($data[0]->totalAMonth , 0, '.', ',');
        $data[0]->month = Carbon::now()->subDays($this->subDaysLunar)->month;
        // dd($data);
        return $data;
    }
}
