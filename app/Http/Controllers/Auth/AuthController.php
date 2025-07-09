<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('user')) {
                return redirect()->intended('voter-dashboard');
            }
            return redirect()->intended('admin-dashboard');
        }

        return view('auth.login');
    }

    public function login_auth(Request $request)
    {
        $request->validate([
            'cnic' => 'required|string|max:255',
            'password' => 'required|min:8|string',
        ]);

        // Check if the "remember" checkbox is selected
        $remember = $request->has('remember');

        if (Auth::attempt($request->only('cnic', 'password'), $remember)) {
            $user = Auth::user();
            // session(['2fa_email' => $request->email]);

            // if ($user->two_factor_enabled) {
            //     $user->generateTwoFactorCode();
            //     $user->notify(new TwoFactorCodeNotification);

            //     Auth::logout();
            //     $request->session()->put('2fa_user_id', $user->id);

            //     return redirect()->route('2fa.challenge');
            // }

            $request->session()->regenerate();
            if($user->hasRole('admin'))
            {
                return redirect()->intended('admin-dashboard');
            }
            elseif ($user->hasRole('candidate')) {
                return redirect()->intended('candidate-dashboard');
            }
            elseif ($user->hasRole('voter')) {
                return redirect()->intended('voter-dashboard');
            }
            return redirect()->intended('admin-dashboard');
        }

        return redirect()->back()->withErrors(['cnic' => 'Inavlid Credentials!']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_auth(Request $request)
    {
        $request->validate([
            'cnic' => 'required|string|max:255',
            'password' => 'required|min:8|string',
        ]);

        // Try to find user by cnic, name, and email
        $user = User::where('cnic', $request->cnic)->first();

        if ($user) {
            // Only update password if it is null
            if (is_null($user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                $user->generateTwoFactorCode();
                $user->notify(new TwoFactorCodeNotification);
                $request->session()->put('2fa_user_id', $user->id);
                
                return redirect()->route('2fa.challenge');
            }
            else {
                return redirect()->back()->withErrors(['cnic' => 'User already registered! Please login.']);
            }
        } else {
            return redirect()->back()->withErrors(['cnic' => 'Data not found! Please make sure you have made your CNIC.']);
        }

        Auth::login($user);

        return redirect()->intended('voter-dashboard');
    }

    public function logout(Request $request)
    {
        // if (Auth::check()) {
        //     $id = Auth::user()->id;
        //     $user = User::findOrFail($id);
        //     $user->is_online = false;
        //     $user->last_seen_at  = now();
        //     $user->save();
        // }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
