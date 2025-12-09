<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Show the password reset request form
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Send the password reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate a token
        $token = Str::random(60);

        // Remove any existing tokens for this email, then save the new token
        DB::table('password_resets')->where('email', $request->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send email to the user with the reset link
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::send('auth.emails.password-reset', ['resetUrl' => $resetUrl], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // app/Http/Controllers/PasswordResetController.php

    public function showResetForm($token, $email)
    {
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Check if token exists in the password_resets table
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Find the user and update their password
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password has been reset successfully!');
    }
}
