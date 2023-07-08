<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{
    public function index(){

        return inertia('Service/Index', [
            'services' => Service::orderBy("reference", "ASC")->get()
        ]);
    }

    public function store(ServiceRequest $request){
        Service::create($request->validated());

        return inertia('Service/Index');
    }

    public function update(ServiceRequest $request, Service $service){
        $service->update($request->validated());

        return inertia('Service/Index');
    }

    public function destroy(Service $service){
        $service->delete();
        return inertia('Service/Index');
    }
}
