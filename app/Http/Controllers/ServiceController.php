<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{
    public function index(){
 
        return inertia('Service/Index', [
            'services' => Service::orderBy("id", "ASC")->get()
        ]);
    }

    public function store(ServiceRequest $request){

        $service = Service::create($request->validated());

        if($request->image != null){
            /** @var UploadedFile|null $image */
            $image = $request->validated('image');
            if ($image != "null" && !$image->getError()){
                $data['image'] = $image->store('service', 'public');
                $service->update($data);
            }
        }

        return redirect()->back()->with(['success' => 'Le service a bien été créé.']);
    }

    public function update(ServiceRequest $request, Service $service){

        $service->update($request->validated());

        if($request->image != null){
            /** @var UploadedFile|null $image */
            $image = $request->validated('image');
            if ($image != "null" && !$image->getError()){
                $data['image'] = $image->store('service', 'public');
                $service->update($data);
            }
        }

        return redirect()->back()->with(['success' => 'Le service a bien été modifié.']);
    }

    public function destroy(Service $service){
        $service->delete();
        
        return redirect()->back()->with(['success' => 'Le service a bien été supprimé.']);
    }
}
