<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function index(){
 
        return inertia('Order/Index', [
            'orders' => Order::orderBy("id", "ASC")->with("services")->get(),
            'services' => Service::all()
        ]);
    }

    public function show(Order $order){
        return inertia('Order/Show', [
            'order' => $order
        ]);
    }

    // **************************************************************************************************************************************************************************************

    public function store(OrderRequest $request){

        // dd($request);

        $order = Order::create($request->validated());

        // Total Price

        $data['price'] = 0.0;
        // foreach ($request->quantity as $key => $item) {
        //     $data['price'] += $item['price'] * $item['quantity'];
        // }
        $order->update($data);

        // Service

        // Je vérifie qu'il y a bien des services qui ont été sélectionné
        if($request->servicesList != null){
            $order->services()->sync($this->prepareDataToSync($request->servicesList)); 
        }

        return redirect()->back()->with(['success' => 'Le bon de commande a bien été créé.']);
    }

    // **************************************************************************************************************************************************************************************

    public function update(OrderUpdateRequest $request, Order $order){

        // dd($request);

        $order->update($request->validated());

        // Je vérifie qu'il y a bien des services qui ont été sélectionné
        if($request->servicesList != null){
            $order->services()->sync($this->prepareDataToSync($request->servicesList)); 
        } 

        return redirect()->back()->with(['success' => 'Le bon de commande a bien été modifié.']);
    }

    // **************************************************************************************************************************************************************************************


    public function destroy(Order $order){
        $order->delete();
        return redirect()->back()->with(['success' => 'Le bon de commande a bien été supprimé.']);
    }

    // ADDITIONALS

    public function prepareDataToSync($data){
        for($i = 0; $i <= count($data) - 1 ; $i++){
            $service_id_array[$data[$i]['id']] = ['quantity' => $data[$i]['pivot']['quantity'], 'price' => $data[$i]['price'] * $data[$i]['pivot']['quantity']];
        }
        return $service_id_array;
    }

    public function totalPrice(Request $request){
        $data = 0;
        for($i = 0; $i <= count($request->servicesList) - 1 ; $i++){
            $value = intval($request->servicesList[$i]['pivot']['quantity']) * intval($request->servicesList[$i]['price']);
            $data = $data + $value;
        }
        return response()->json($data);
    }
}
