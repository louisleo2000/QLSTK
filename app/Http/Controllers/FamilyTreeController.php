<?php

namespace App\Http\Controllers;

use App\Models\Family_tree;
use App\Http\Requests\StoreFamily_treeRequest;
use App\Http\Requests\UpdateFamily_treeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        if($request->ajax())
        {
            $family_tree = Family_tree::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,  
            ]);
        }
        return response()->json(['success' => 'Thêm thành công '.$request->name],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Family_tree  $family_tree
     * @return \Illuminate\Http\Response
     */
    public function show(Family_tree $family_tree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family_tree  $family_tree
     * @return \Illuminate\Http\Response
     */
    public function edit(Family_tree $family_tree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFamily_treeRequest  $request
     * @param  \App\Models\Family_tree  $family_tree
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFamily_treeRequest $request, Family_tree $family_tree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Family_tree  $family_tree
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family_tree $family_tree)
    {
        //
    }
}
