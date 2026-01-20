<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage};
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'avatar' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        // Redirect counselors to their dashboard
        if ($user->isCounselor()) {
            return redirect()->route('counselor.dashboard')->with('success', 'Profile updated successfully!');
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect counselors to their dashboard
        if ($user->isCounselor()) {
            return redirect()->route('counselor.dashboard')->with('success', 'Password updated successfully!');
        }

        return back()->with('success', 'Password updated successfully!');
    }

    public function updateVideoPreferences(Request $request)
    {
        $validated = $request->validate([
            'preferred_video_service' => 'required|in:jitsi,google_meet,zoom,phone_call',
            'auto_start_video' => 'boolean',
            'default_camera_on' => 'boolean',
            'default_microphone_on' => 'boolean',
        ]);

        // Convert checkbox values to boolean
        $validated['auto_start_video'] = $request->has('auto_start_video');
        $validated['default_camera_on'] = $request->has('default_camera_on');
        $validated['default_microphone_on'] = $request->has('default_microphone_on');

        $user = auth()->user();
        $user->update($validated);

        // Redirect counselors to their dashboard
        if ($user->isCounselor()) {
            return redirect()->route('counselor.profile.edit')->with('success', 'Video preferences updated successfully!');
        }

        return back()->with('success', 'Video preferences updated successfully!');
    }

    public function removeAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        // Redirect counselors to their dashboard
        if ($user->isCounselor()) {
            return redirect()->route('counselor.dashboard')->with('success', 'Profile image removed successfully!');
        }

        return back()->with('success', 'Profile image removed successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = auth()->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}