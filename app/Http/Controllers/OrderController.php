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

    public function store(OrderRequest $request){
        $order = Order::create($request->validated());

        // Total Price

        $data['price'] = 0.0;
        foreach ($request->quantity as $key => $item) {
            $data['price'] += $item['price'] * $item['quantity'];
        }
        $order->update($data);

        // Service

        // Je vérifie qu'il y a bien des services qui ont été sélectionné
        if($request->services != null){
            // Je boucle selon le nombre de service sélectionné
            for($i = 0; $i <= count($request->services) - 1 ; $i++){
                // Je récupère l'index du service
                $indexOf = array_search($request->services[$i]['id'], array_column($request->quantity, 'id'));
                // J'assemble les données que je stock ensuite
                $service_id_array[$request->services[$i]['id']] = ['quantity' => $request->quantity[$indexOf]['quantity'], 'price' => $request->quantity[$indexOf]['price']];
            }
            $order->services()->sync($service_id_array); 
        }

        return redirect()->back()->with(['success' => 'Le bon de commande a bien été créé.']);
    }

    public function update(OrderUpdateRequest $request, Order $order){

        $order->update($request->validated());

        // Je vérifie qu'il y a bien des services qui ont été sélectionné
        if($request->services != null){
            // Je boucle selon le nombre de service sélectionné
            for($i = 0; $i <= count($request->services) - 1 ; $i++){
                // Je récupère l'index du service
                $indexOf = array_search($request->services[$i]['id'], array_column($request->quantity, 'id'));
                
                // J'assemble les données que je stock ensuite
                $service_id_array[$request->services[$i]['id']] = ['quantity' => $request->quantity[$indexOf]['quantity'], 'price' => $request->quantity[$indexOf]['price']];
            }
            $order->services()->sync($service_id_array); 
        } 

        return redirect()->back()->with(['success' => 'Le bon de commande a bien été modifié.']);
    }

    public function destroy(Order $order){
        $order->delete();
        return redirect()->back()->with(['success' => 'Le bon de commande a bien été supprimé.']);
    }
}
