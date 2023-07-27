<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function index(){
 
        $AllServices = Service::with('group')->get();
        $services = collect([]);

        foreach ($AllServices as $service) {
            if ($service->group == null) {
                $services->push($service);
            }else{
                if($services->doesntContain($service->group)){
                    $services->push($service->group);
                }
            }
        };

        return inertia('Order/Index', [
            'orders' => Order::orderBy("id", "ASC")->with("services")->get(),
            'services' => $services
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

        $groups = Group::all();

        for($i = 0; $i <= count($data) - 1 ; $i++){

            if(!$groups->contains('name', $data[$i]['name'])){
                // Service sans groupe
                $service_id_array[$data[$i]['id']] = ['quantity' => $data[$i]['pivot']['quantity'], 'price' => $data[$i]['price'] * $data[$i]['pivot']['quantity']];
            }else{

                $group = Group::where('name', $data[$i]['name'])->with('services')->get()->first();
                $servicesFiltered = $group->services->sortBy('maxQuantity');

                // Je récupère l'item qui vaut null est je le place en dernière place
                if($servicesFiltered->first()->maxQuantity == null){
                    $saveItem = $servicesFiltered->first();
                    $servicesFiltered = $servicesFiltered->slice(1);
                    $servicesFiltered->push($saveItem);
                }

                $diff = 0;

                foreach ($servicesFiltered as $item) {
                
                    if($item->maxQuantity != null && $data[$i]['pivot']['quantity'] > 0){

                        $diff = $item->maxQuantity - $diff;
                        $data[$i]['pivot']['quantity'] -= $diff;

                        $service_id_array[$item['id']] = ['quantity' => 1, 'price' => $item['price'] * $data[$i]['pivot']['quantity']];

                    }elseif($data[$i]['pivot']['quantity'] > 0){
                        $service_id_array[$item['id']] = ['quantity' => $data[$i]['pivot']['quantity'], 'price' => $item['price'] * $data[$i]['pivot']['quantity']];
                    };

                }
                

            }
            
        }
        return $service_id_array;
    }

    // ***** Prix total *****

    public function totalPrice(Request $request){

        $data = 0.0;
        
        if($request->servicesList){

            $groups = Group::all();

            for($i = 0; $i <= count($request->servicesList) - 1 ; $i++){

                $service = $request->servicesList[$i];

                if(!$groups->contains('name', $service['name'])){
                    // Service sans groupe
                    $value = intval($service['pivot']['quantity']) * intval($service['price']);
                    $data = $data + $value;
                }else{
                    // Service avec groupe
                    $group = Group::where('name', $service['name'])->with('services')->get()->first();
                    $servicesFiltered = $group->services->sortBy('maxQuantity');

                    // Je récupère l'item qui vaut null est je le place en dernière place
                    if($servicesFiltered->first()->maxQuantity == null){
                        $saveItem = $servicesFiltered->first();
                        $servicesFiltered = $servicesFiltered->slice(1);
                        $servicesFiltered->push($saveItem);
                    }

                    $diff = 0;

                    foreach ($servicesFiltered as $item) {
                    
                        if($item->maxQuantity != null && $service['pivot']['quantity'] > 0){
                            $data += $item->price;
                            $diff = $item->maxQuantity - $diff;
                            $service['pivot']['quantity'] -= $diff;
                        }elseif($service['pivot']['quantity'] > 0){
                            $data += $item->price * $service['pivot']['quantity'];
                        };

                    }
                }

            }
        }

        return response()->json($data);
    }
}
