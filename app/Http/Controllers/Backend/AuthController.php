<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function __constructor()
    {

    }

    public function index()
    {
        // CHECK IF USER ALREADY LOGGED IN
        if (Auth::id() > 0) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('backend.auth.login');
        }
    }


    public function login( AuthRequest $request)
    {
        $credential = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credential)) {
            return redirect()->route('admin.dashboard');
        }
        else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');

    }
}
