<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an AJAX login request.
     */
    public function ajaxLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Determine redirect URL based on user role
            if ($user->role === 'admin') {
                $redirectUrl = route('admin.dashboard');
            } elseif ($user->role === 'counselor') {
                $redirectUrl = route('counselor.dashboard');
            } elseif ($user->role === 'user') {
                $redirectUrl = route('dashboard');
            } else {
                $redirectUrl = route('dashboard');
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }
}