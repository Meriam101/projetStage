<?php // ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; // Ce Request doit valider les champs pour User ET Admin
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash; // Nécessaire pour la validation du mot de passe dans destroyAdmin
use Illuminate\Validation\ValidationException; // Nécessaire pour la validation du mot de passe dans destroyAdmin

class ProfileController extends Controller
{
    // --- Méthodes pour User Standard ---

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Utilise la vue pour user standard
        return view('profile.edit', [
            'user' => Auth::user(), // Ou $request->user() qui utilise le guard par défaut
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // --- Méthodes DÉDIÉES pour Admin ---

    /**
     * Display the admin's profile form.
     */
    public function editAdmin(Request $request): View // Renommée
    {
        // Utilise la vue spécifique à l'admin
        return view('Dashboard.Admin.edit', [ // Chemin de vue admin
            'user' => Auth::guard('admin')->user(), // Récupère l'admin via le guard admin
        ]);
    }

    /**
     * Update the admin's profile information (name, email).
     */
   
    /**
     * Delete the admin's account.
     */
   
}