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
        $user = Auth::user();
        
        // Ensure user has a profile record
        if (!$user->profile) {
            $user->profile()->create([
                'email_notifications' => true,
                'sms_notifications' => false,
            ]);
            $user->load('profile');
        }
        
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Ensure user has a profile record
        if (!$user->profile) {
            $user->profile()->create([
                'email_notifications' => true,
                'sms_notifications' => false,
            ]);
            $user->load('profile');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB max
            ]
        ]);

        $user = Auth::user();

        try {
            // Ensure user has a profile record
            if (!$user->profile) {
                $user->profile()->create([
                    'email_notifications' => true,
                    'sms_notifications' => false,
                ]);
                $user->load('profile');
            }

            // Delete old picture if exists
            if ($user->profile && $user->profile->profile_picture) {
                $oldPath = $user->profile->profile_picture;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Generate unique filename with user ID and timestamp
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;
            
            // Store the file with proper permissions
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            
            // Debug: Log the path
            \Log::info('Profile picture stored at: ' . $path);
            
            // Verify the file was stored successfully
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('Failed to store profile picture');
            }

            // Debug: Update profile with new picture path
            $result = $user->profile()->update(['profile_picture' => $path]);
            \Log::info('Profile update result: ' . ($result ? 'success' : 'failed'));

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'url' => Storage::url($path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete the user's profile picture
     */
    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::user();

        try {
            if ($user->profile && $user->profile->profile_picture) {
                $profilePicturePath = $user->profile->profile_picture;
                
                // Delete file from storage
                if (Storage::disk('public')->exists($profilePicturePath)) {
                    Storage::disk('public')->delete($profilePicturePath);
                }
                
                // Remove from database
                $user->profile()->update(['profile_picture' => null]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture deleted successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No profile picture found to delete'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the user's profile information
     */
public function update(Request $request)
{
    $user = Auth::user();

    // Ensure user has a profile record
    if (!$user->profile) {
        $user->profile()->create([
            'email_notifications' => true,
            'sms_notifications' => false,
        ]);
        $user->load('profile');
    }

    // Validate user fields
    $userData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone_number' => 'nullable|string|max:20',
        'email_notifications' => 'nullable|boolean',
        'sms_notifications' => 'nullable|boolean',
    ]);

    // Convert checkbox values to boolean
    $userData['email_notifications'] = $request->has('email_notifications');
    $userData['sms_notifications'] = $request->has('sms_notifications');

    // Validate profile fields
    $profileData = $request->validate([
        'date_of_birth' => 'nullable|date|before:today',
        'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
        'bio' => 'nullable|string|max:500',
        'height' => 'nullable|numeric|min:50|max:300',
        'weight' => 'nullable|numeric|min:20|max:500',
        'fitness_goal' => 'nullable|string',
        'experience_level' => 'nullable|string',
    ]);

    // Handle profile picture upload separately with enhanced validation
    if ($request->hasFile('profile_picture')) {
        $profilePictureData = $request->validate([
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB max
            ]
        ]);

        try {
            // Delete old picture if exists
            if ($user->profile && $user->profile->profile_picture) {
                $oldPath = $user->profile->profile_picture;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Generate unique filename with user ID and timestamp
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;
            
            // Store the file with proper permissions
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            
            // Verify the file was stored successfully
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('Failed to store profile picture');
            }

            // Add to profile data
            $profileData['profile_picture'] = $path;
            
        } catch (\Exception $e) {
            return back()->withErrors(['profile_picture' => 'Failed to upload profile picture: ' . $e->getMessage()]);
        }
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
        if ($user->profile && $user->profile->profile_picture) {
            $profilePicturePath = $user->profile->profile_picture;
            if (Storage::disk('public')->exists($profilePicturePath)) {
                Storage::disk('public')->delete($profilePicturePath);
            }
        }

        // Delete user account
        $user->delete();

        // Logout
        Auth::logout();

        return redirect()->route('index')
            ->with('success', 'Your account has been deleted.');
    }
}
