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
            ->editColumn('dod', function ($request) {
                //format dod to dd/mm/yyyy
                $dod = date('d/m/Y', strtotime($request->dod));
                return $dod;
            })
            ->addColumn('action', function ($row) {

                $btn = '<a onclick="getMember(' . $row->id . ')"  class="edit btn btn-primary btn-sm">Sửa</a>';
                $btn = $btn . '<a onclick="deleteMember(' . $row->id . ')" class="edit btn btn-danger btn-sm">Xóa</a>';

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
        $father_id = null;
        $mother_id = null;
        $couple_id = null;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => 'required',
            'gender' => 'required',
        ]);
        // dd($request['couple_id']);
        // if ($request->ajax()) {


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
        if (count($request['couple_id']) > 1) {
            //$request['couple_id'] to string
            $couple_id = implode(",", $request['couple_id']);
        } else if (count($request['couple_id']) == 1) {
            $couple_id = $request['couple_id'][0];
        }


        $members =  Members::create([
            'family_tree_id' => Auth::user()->familyTree[0]->id,
            'name' => $request['name'],
            'dob' => $request['dob'],
            'dod' => $dod,
            'gender' => $request['gender'],
            'img' => $img,
            'father_id' => $father_id,
            'mother_id' => $mother_id,
            'couple_id' => $couple_id
        ]);

        if (count($request['couple_id']) >= 1) {
            foreach ($request['couple_id'] as $couple) {
                if ($couple != 0) {
                    $partner = Members::find($couple);
                    $idremove =  str_replace(",", " ", $partner->couple_id);

                    if (!str_contains($idremove, $members->id)) {
                        if ($partner->couple_id == null) {
                            $partner->couple_id = $members->id;
                        } else {
                            $partner->couple_id = $partner->couple_id . "," . $members->id;
                        }
                    }
                    $partner->save();
                }
            }
        }

        return response()->json(['success' => 'Thành công'], 200);
    }

    public function show($id)
    {
        //get first member by user and family tree
        $member = Members::where('family_tree_id', '=', Auth::user()->familyTree[0]->id)->where('id', '=', $id)->first();

        //return reponse json
        return response()->json($member);
    }


    public function edit(Request $request, $id)
    {
        //
        //validate request  
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => 'required',
            'gender' => 'required',
        ]);

        $members =  Members::find($id);
        if ($request->ajax()) {
            $img = $members->img;
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

            $dod = $members->dod;
            $father_id = $members->father_id;
            $mother_id = $members->mother_id;
            $couple_id = $members->couple_id;

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
            if (count($request['couple_id']) > 1) {
                //$request['couple_id'] to string
                $couple_id = implode(",", $request['couple_id']);
            } else if (count($request['couple_id']) == 1) {
                $couple_id = $request['couple_id'][0];
            }

            $members->name = $request['name'];
            $members->dob = $request['dob'];
            $members->dod = $dod;
            $members->gender = $request['gender'];
            $members->img = $img;
            $members->father_id = $father_id;
            $members->mother_id = $mother_id;
            $members->couple_id = $couple_id;

            if (count($request['couple_id']) >= 1) {
                foreach ($request['couple_id'] as $couple) {
                    if ($couple != 0) {
                        $partner = Members::find($couple);
                        $idremove =  str_replace(",", " ", $partner->couple_id);

                        if (!str_contains($idremove, $members->id)) {
                            if ($partner->couple_id == null) {
                                $partner->couple_id = $members->id;
                            } else {
                                $partner->couple_id = $partner->couple_id . "," . $members->id;
                            }
                        }
                        $partner->save();
                    }
                }
            }

            if ($members->save()) {
                return response()->json(['success' => 'Sửa thành công ' . $request->name], 200);
            } else {
                return response()->json(['error' => 'Sửa thất bại'], 500);
            }
        }
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


    public function destroy($id)
    {
        //delete member
        $members = Members::find($id);
        $partner = Members::find($members->couple_id);
        if ($partner != null) {
            $partner->couple_id = str_replace($id . ",", "", $partner->couple_id);
            if ($partner->save()) {
                if ($members->delete()) {
                    return response()->json(['success' => 'Xóa thành công']);
                } else {
                    return response()->json(['error' => 'Xóa thất bại']);
                }
            }
        } else {
            if ($members->delete()) {
                return response()->json(['success' => 'Xóa thành công']);
            } else {
                return response()->json(['error' => 'Xóa thất bại']);
            }
        }
    }
}
