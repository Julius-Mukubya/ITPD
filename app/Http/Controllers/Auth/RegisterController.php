<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Handle a regular registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'], // 2MB max
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for new registrations
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);
            $userData['avatar'] = 'avatars/' . $avatarName;
        }

        $user = User::create($userData);

        // Log the user in
        Auth::login($user);

        // Determine redirect URL based on user role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'counselor':
                return redirect()->route('counselor.dashboard');
            case 'user':
                return redirect()->route('home'); // Users redirect to homepage, not a separate dashboard
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Handle an AJAX registration request.
     */
    public function ajaxRegister(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'terms' => ['required', 'accepted'],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'], // 2MB max
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user', // Default role for new registrations
            ];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars', $avatarName);
                $userData['avatar'] = 'avatars/' . $avatarName;
            }

            $user = User::create($userData);

            // Log the user in
            Auth::login($user);

            // Add success flash message for toast display on destination page
            session()->flash('success', 'Account created successfully! Welcome to WellPath Platform, ' . $user->name . '.');

            // Determine redirect URL based on user role
            switch ($user->role) {
                case 'admin':
                    $redirectUrl = route('admin.dashboard');
                    break;
                case 'counselor':
                    $redirectUrl = route('counselor.dashboard');
                    break;
                case 'user':
                    $redirectUrl = route('home'); // Users redirect to homepage, not a separate dashboard
                    break;
                default:
                    $redirectUrl = route('dashboard');
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully! Welcome to WellPath Platform.',
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}