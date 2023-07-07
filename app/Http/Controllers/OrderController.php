<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return inertia('Order/Index');
    }

    public function show(String $id){
        return inertia('Order/Show');
    }
}
