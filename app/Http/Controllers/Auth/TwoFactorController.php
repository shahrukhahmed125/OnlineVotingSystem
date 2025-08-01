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

    public function verify(Request $request, $id)
    {
        $code = $request->code;
        $user = User::findOrFail($id);

        if ($code === $user->two_factor_code && $user->two_factor_expires_at > now()) {
            $user->resetTwoFactorCode();
            
            session(['2fa_verified_at' => now()->timestamp]);

            Auth::login($user);
            $request->session()->regenerate();
            
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.home');
            } elseif ($user->hasRole('candidate') || $user->hasRole('voter')) {
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors(['2fa_code' => 'Invalid or expired 2FA code.']);
    }
}
