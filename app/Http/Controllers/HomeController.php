<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExportFlower;
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
}
