<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flower;

class FlowerController extends Controller
{

    public function index () {

        $allFlower = $this->getAllFlower();

        return view('Flower.index', compact('allFlower'));
    }
    
    public function StoreFlower ( Request $request){
        // dd($request);

        $flower = new Flower() ;

        $flower->flower_name    = $request->flower_name;
        $flower->flower_code    = $request->flower_code;
        $flower->supplier       = $request->supplier;

        $flower->save();

        $data = Flower::latest()->first();

        // dd($data->created_at);

        return response([
            'data' => $data,
        ]);
    } 

    function getAllFlower(){

        // return Flower::paginate(4);
        return Flower::orderBy("flower_name","asc")->get();
    }

    function countAllFlower(){
        return Flower::all()->count();
    }
}
