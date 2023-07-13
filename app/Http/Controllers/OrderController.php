<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

        return inertia('Order/Index', [
            'orders' => Order::all(),
            'services' => Service::all()
        ]);
    }

    public function show(Order $order){
        return inertia('Order/Show', [
            'order' => $order
        ]);
    }

    public function store(OrderRequest $request){
        Order::create($request->validated());

        return inertia('Order/Index');
    }

    public function update(OrderRequest $request, Order $order){
        $order->update($request->validated());

        return inertia('Order/Index');
    }

    public function destroy(Order $order){
        $order->delete();
        return redirect()->back();
    }
}
