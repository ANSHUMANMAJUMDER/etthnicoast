<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
     return view('frontend.login');
    }

public function login_store(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

   

    if (Auth::guard('frontend')->attempt([
        'email'    => $request->email,
        'password' => $request->password,
    ])) {

        $user = Auth::guard('frontend')->user();
       
        // Role check
        if ($user->role_name !== 'etthnicoast_user') {
            Auth::guard('frontend')->logout();
            return back()->withInput()->with('error', 'Access denied.');
        }

        if (isset($user->status) && !$user->status === 'active') {
            Auth::guard('frontend')->logout();
            return back()->withInput()->with('error', 'Your account is deactivated.');
        }

        $request->session()->regenerate();

        $user->update(['last_login' => now()]);

        return redirect()->intended(route('frontend.index'))
            ->with('success', 'Login successful.');
    }

    return back()->withInput()->with('error', 'Invalid email or password.');
}

    public function register(){
      return view('frontend.register');
    }
      public function register_store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        // $user = User::create([
        //     'name'         => $request->first_name . ' ' . $request->last_name,
        //     'user_id'      => 'ETH' . strtoupper(Str::random(8)),
        //     'email'        => $request->email,
        //     'join_date'    => now()->format('Y-m-d'),
        //     'phone_number' => $request->phone_number,
        //     'status'       => 'active',
        //     'role_name'    => 'etthnicoast_user',
        //     'password'     => Hash::make($request->password),
        // ]);
        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->user_id = 'ETH' . strtoupper(Str::random(8));
        $user->email = $request->email;
        $user->join_date = now()->format('Y-m-d');
        $user->phone_number = $request->phone_number;
        $user->status = 'active';
        $user->role_name = 'etthnicoast_user';
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::guard('frontend')->login($user);

        return redirect()->route('frontend.login')->with('success', 'Registration successful.');
    }
}
