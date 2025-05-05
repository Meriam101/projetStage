<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
// Use the standard LoginRequest if you implement login later, or remove if unused
// use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; // Make sure this model exists and is configured for auth
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// ↑↑↑ AJOUTEZ CETTE LIGNE ↑↑↑
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function showRegisterForm()
    {
        return view('Dashboard.Admin.signup'); 
    }

    public function register(Request $request)
    {
        // Validation rules are okay, 'confirmed' checks for 'password_confirmation' field
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'], // Ensure 'admins' table exists
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Optional: Fire the Registered event
        // event(new Registered($admin));

        // Attempt to login using the 'admin' guard
        Auth::guard('admin')->login($admin);

        $request->session()->regenerate();  // Regenerate the session

        // Redirect to the named admin dashboard route
        return redirect()->route('dashboard.admin');
    }

    // Removed the broken store() method that was intended for login
    public function login(AdminLoginRequest $request)
    {
        if ($request->authenticate()) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed')) ?? 'Authentication failed.']);
    }
    
    // Keep other methods like destroy (logout) if needed
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to homepage or admin login page
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->input('current_password'), $admin->password)) {
             // Maintenant, PHP sait où trouver ValidationException
            throw ValidationException::withMessages([
                'current_password' => __('The provided password does not match your current password.'),
            ])->errorBag('updatePassword');
        }

        $validated = $request->validateWithBag('updatePassword', [
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        $admin->password = Hash::make($validated['password']);
           $admin->save();

        return back()->with('status', 'password-updated');
    }
    public function updateAdmin(ProfileUpdateRequest $request): RedirectResponse // Renommée
    {
        $admin = Auth::guard('admin')->user();
        $admin->fill($request->validated());

        // Vérification email pour Admin (si nécessaire et configuré sur le modèle Admin)
        if ($admin->isDirty('email')) {
             if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
                 $admin->email_verified_at = null;
                 $admin->sendEmailVerificationNotification();
             }
        }
        $admin->save();

        // Redirige vers le profil admin
        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the admin's account.
     */
    public function destroyAdmin(Request $request): RedirectResponse // Renommée
    {
        $request->validateWithBag('userDeletion', [
            // Validation spécifique pour le guard admin
            'password' => ['required', 'current_password:admin'],
        ]);

        $admin = Auth::guard('admin')->user();

        Auth::guard('admin')->logout(); // Logout spécifique au guard admin
        $admin->delete();

        $request->session()->invalidate(); // Invalide la session globale
        $request->session()->regenerateToken();

        return Redirect::to('/'); // Ou vers la page de login admin
    }
    
}
