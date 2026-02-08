<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'u_email' => 'required|email',
            'u_password' => 'required',
        ]);

        // Find user by email
        $user = User::where('u_email', $request->u_email)->first();

        // Check if user exists and password matches
        if ($user && Hash::check($request->u_password, $user->u_password)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'u_email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('u_email'));
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
