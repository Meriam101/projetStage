<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
   
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(AdminLoginRequest $request)
    {
        //
       
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ADMIN);
    }

    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
