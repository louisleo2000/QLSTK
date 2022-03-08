<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('pages.profile');
    }

   
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
       $user->update($request->all());
        
        return back()->withStatus('Thay đổi thông tin thành công');
    }

    
    public function password(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus('Đổi mật khẩu thành công');
    }
}
