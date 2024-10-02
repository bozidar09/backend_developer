<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('admin.auth.login.create');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($userData)) {
            // primjer bacanja validation exceptiona za pojedini input
            throw ValidationException::withMessages(['email' => 'Vaši podaci za prijavu nisu točni']);
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard.index')->with('success', 'Uspješno ste se prijavili');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Uspješno ste se odjavili');
    }
}
