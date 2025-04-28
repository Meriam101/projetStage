<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
// Use the standard LoginRequest if you implement login later, or remove if unused
// use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; // Make sure this model exists and is configured for auth
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; // Optional: Fire event if needed

class AdminController extends Controller
{

    public function showRegisterForm()
    {
        return view('Dashboard.Admin.signup'); // Ensure this path is correct
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
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed')) ?? 'Authentication failed.'
    ]);
    }
    
    // Keep other methods like destroy (logout) if needed
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to homepage or admin login page
    }

    // Add placeholders or remove unused RESTful methods
    // public function show($id) { /* ... */ }
    // public function edit($id) { /* ... */ }
    // public function update(Request $request, $id) { /* ... */ }

}