<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{  
     public function passwordEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

    // Détecte si l’email appartient à un admin
    $broker = \App\Models\Admin::where('email', $request->email)->exists()
        ? 'admins'
        : 'users';

    $status = Password::broker($broker)->sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }
    
    public function passwordReset($token) {
        return view('auth.reset-password', ['token' => $token]);
    }
    function passwordUpdate(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => ['required','email'],
            'password' => ['required','confirmed'],
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user,string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            });
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
