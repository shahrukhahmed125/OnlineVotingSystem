<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'email' => 'required|email|string',
            'password' => 'required|min:8|string',
        ]);

        // Check if the "remember" checkbox is selected
        $remember = $request->has('remember');

        if (Auth::attempt($request->only('email', 'password'), $remember)) {
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

            if ($user->hasRole('user')) {
                return redirect()->intended('voter-dashboard');
            }
            return redirect()->intended('admin-dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Inavlid Credentials!']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_auth(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cnic' => 'required|string|unique:users,cnic|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|string',
        ]);

        $user = new User;
        $user->user_id = $user->generateUserId();
        $user->fill($request->all());
        $user->assignRole('user');
        $user->save();

        // event(new Registered($user));
        // $user->sendEmailVerificationNotification();
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
