<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Http\Requests\StoreMembersRequest;
use App\Http\Requests\UpdateMembersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;
use Yajra\Datatables\Datatables;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $male = [];
        $female = [];
        $couple = [];
        //check family tree
        $family_tree = Auth::user()->familyTree;
        //get lenght family_tree


        // dd($family_tree);
        if (count($family_tree) > 0) {
            //get members male
            $male = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->where('gender', '=', 'male')->get();

            //get member female
            $female = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->where('gender', '=', 'female')->get();

            $couple = Members::all();
        }

        $data = array(
            'female' => $female,
            'male' => $male,
            'couples' => $couple,
            'title' => 'Thành viên',
            'active' => 2
        );
        return view('pages.members', $data);
    }

    public function data()
    {
        $family_tree = Auth::user()->familyTree;
        $members = [];
        if (count($family_tree) > 0) {
            $members = Auth::user()->familyTree[0]->members;
        }

        return Datatables::of($members)
            ->editColumn('img', '<img src="{{$img}}" class="avatar" alt="user1">')
            ->editColumn('dob', function ($request) {
                //format dob to dd/mm/yyyy
                $dob = date('d/m/Y', strtotime($request->dob));
                return $dob;
            })
            ->addColumn('action', function ($row) {

                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Sửa</a>';
                $btn = $btn . '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Xóa</a>';

                return $btn;
            })
            ->rawColumns(['img', 'action'])
            ->make(true);
        //dd($a);

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
        //validate request
        $dod = null;
        $father_id = 0;
        $mother_id = 0;
        $couple_id = 0;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => 'required',
            'gender' => 'required',
        ]);
        if ($request->ajax()) {


            $mb = Members::where('name', '=', $request['name'])->where('dob', '=', $request['dob'])->where('gender', '=', $request['gender'])->get();
            $img = "https://icon-library.com/images/no-user-image-icon/no-user-image-icon-27.jpg";
            if ($request->hasFile('img')) {
                //get name and port of server
                $serverName = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];
                //get file name
                $fileName = $request['name'] . $request['dob'] . "." . $request->file('img')->getClientOriginalExtension();
                //save img in storage public/img
                $request->file('img')->storeAs('public/img', $fileName);
                $path = $serverName . "/storage" . '/img/' . $fileName;
                $img = $path;
            }
            if (count($mb) > 0) {
                return response()->json(['error' => 'Thành viên này đã tồn tại']);
            }
            //check $request['dod'] != ""
           
            if ($request['dod'] != "") {
                $dod = $request['dod'];
            }

            //check father_id
            if ($request['father_id'] != 0) {
                $father_id = $request['father_id'];
            }

            //check mother_id
            if ($request['mother_id'] != 0) {
                $mother_id = $request['mother_id'];
            }

            //check couple_id
            if ($request['couple_id'] != 0) {
                $couple_id = $request['couple_id'];
            }

            $members =  Members::create([
                'family_tree_id' => Auth::user()->familyTree[0]->id,
                'name' => $request['name'],
                'dob' => $request['dob'],
                'dod' => $dod,
                'gender' => $request['gender'],
                'level' => 0,
                'img' => $img,
                'father_id' => $father_id,
                'mother_id' => $mother_id,
                'couple_id' => $couple_id
            ]);
            if ($request['couple_id'] != 0) {
                $partner = Members::find($couple_id);
                $partner->couple_id = $partner->couple_id.",". $members->id;
                if ($partner->save()) {
                    return response()->json(['success' => 'Thành công']);
                }
            }

            return response()->json(['success' => 'Thành công'], 200);




            //save members
            if ($members->save()) {
                return response()->json(['success' => 'Thêm thành công ' . $request->name], 200);
            } else {
                return response()->json(['error' => 'Thêm thất bại'], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMembersRequest  $request
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembersRequest $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function destroy(Members $members)
    {
        //
    }
}
