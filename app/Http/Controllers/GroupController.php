<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;

class GroupController extends Controller
{
    public function index(){
        return inertia('Group/Index', [
            'groups' => Group::orderBy("id", "ASC")->get()
        ]);
    }

    public function store(GroupRequest $request){
        Group::create($request->validated());
        return redirect()->back()->with(['success' => 'Le groupe a bien été créé.']);
    }

    public function update(GroupRequest $request, Group $group){
        $group->update($request->validated());
        return redirect()->back()->with(['success' => 'Le groupe a bien été modifié.']);
    }

    public function destroy(Group $group){
        $group->delete();
        return redirect()->back()->with(['success' => 'Le groupe a bien été supprimé.']);
    }
}
