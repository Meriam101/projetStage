<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function createUser(): View
    {
        return view('auth.forgot-password', [
            'actionRoute' => route('user.password.email'),
            'role' => 'user',
        ]);
    }
    
    public function createAdmin(): View
    {
        return view('auth.forgot-password', [
            'actionRoute' => route('admin.password.email'),
            'role' => 'admin',
        ]);
    }
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('users')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Envoi du mail pour admin
    public function storeAdmin(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('admins')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status == Password::RESET_LINK_SENT
    //                 ? back()->with('status', __($status))
    //                 : back()->withInput($request->only('email'))
    //                         ->withErrors(['email' => __($status)]);
    // }
//     public function store(Request $request): RedirectResponse
// {
//     $request->validate([
//         'email' => ['required', 'email'],
//     ]);

//     // Pour les admins :
//     $status = Password::broker('admins')->sendResetLink(
//         $request->only('email')
//     );

//     return $status == Password::RESET_LINK_SENT
//         ? back()->with('status', __($status))
//         : back()->withInput($request->only('email'))
//                 ->withErrors(['email' => __($status)]);
// }
}
