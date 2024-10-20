<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('admin.auth.register.create');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'same:password_confirmation'], //Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required',
        ]);

        $userData['member_id'] = (new MembershipService())->generate();

        $user = User::create($userData);
        Auth::login($user);

        return redirect()->route('dashboard.index')->with('success', 'Uspješno kreiran novi član ' . $user->fullName());
    }
}
