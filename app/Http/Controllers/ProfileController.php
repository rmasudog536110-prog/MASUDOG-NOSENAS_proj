<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show()
    {

        $user = Auth::user()->load('profile');
        return view('profile.show', compact('user'));
    
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate user fields
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Validate profile fields
        $profileData = $request->validate([
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'bio' => 'nullable|string|max:500',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
            'fitness_goal' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile && $user->profile->profile_picture) {
                Storage::disk('public')->delete($user->profile->profile_picture);
            }

            $profileData['profile_picture'] = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        // Update users table
        $user->update($userData);

        // Update or create user_profile row
        $user->profile()->updateOrCreate([], $profileData);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }


    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
        ]);

        // Convert checkbox values to boolean
        $validated['email_notifications'] = $request->has('email_notifications');
        $validated['sms_notifications'] = $request->has('sms_notifications');

        Auth::user()->update($validated);

        return back()->with('success', 'Notification preferences updated!');
    }

    /**
     * Delete the user's account
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect']);
        }

        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Delete user account
        $user->delete();

        // Logout
        Auth::logout();

        return redirect()->route('index')
            ->with('success', 'Your account has been deleted.');
    }
}
