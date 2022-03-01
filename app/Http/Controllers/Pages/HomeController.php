<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        $data = array(
            'title' => 'Trang chủ',
            'active' => 1,
        );
        return view('pages.home', $data);
    }
}
