<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
        public function show(Request $request)
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            return view('auth.2fa-challenge', compact('user_id', 'user_email'));   
        }
        else
        {
            $user_id = $request->session()->get('2fa_user_id');
            $user_email = User::findOrFail($user_id)->email;

            return view('auth.2fa-challenge', compact('user_id', 'user_email'));           
        }
    }
}
