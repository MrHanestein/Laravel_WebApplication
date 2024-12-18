<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //Index implementation for user login
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            if ($usertype == 'user') {
                return view('dashboard');
            } else if ($usertype == 'home.homepage') {
                return view('admin.index');
            }
            else {
                return redirect()->back();
            }

        }
    }
    public function homepage() {
        return view('home.homepage');
    }
}
