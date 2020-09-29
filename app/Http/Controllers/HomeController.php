<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __contruct(){

    }

    public function index(){
        
        return view('welcome');
    } 
}
