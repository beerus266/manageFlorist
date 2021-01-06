<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExportFlower;
use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportFlowerController;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct(
        FlowerController $FlowerController,
        CustomerController $CustomerController,
        ExportFlowerController $ExportFlowerController
    ){
        $this->flowerContr = $FlowerController;
        $this->customerContr = $CustomerController;
        $this->exportContr = $ExportFlowerController;
    }

    public function index(){
        
        $countFlower = $this->flowerContr->countAllFlower();
        $countCustomer = $this->customerContr->countAllCustomer();
        $amountAMonth = $this->exportContr->getAmountAMonth()[0];

        return view('Home.index',compact('countFlower','countCustomer','amountAMonth'));
    } 

    public function getBarChart(){

        $data = $this->exportContr->getBarChart();
        return response([
        'data' => $data
        ]);
    }
}
