<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', /* Rules\Password::defaults() */],
            'avatar' => ['nullable', 'image'],
            'job' => ['nullable', 'string'],
            'role_id' => ['required', 'string', 'exists:roles,id'],
        ]);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Succesfully stored user' . $data['first_name' . ' ' . $data['last_name']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with('articles', 'role')->first();

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::where('id', $user->id)->with('role')->first();
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('email')->ignore($user)],
            'password' => ['required', /* Rules\Password::defaults() */],
            'avatar' => ['nullable', 'image'],
            'job' => ['nullable', 'string'],
            'role_id' => ['required', 'string', 'exists:roles,id'],
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Succesfully updated user ' . $data['first_name'] . ' ' . $data['last_name']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $name = $user->first_name . ' ' . $user->last_name;
        try {
            $user->delete();
        } catch (\PDOException $e) {
            return redirect()->back()->with('danger', "You can't delete user before related articles");
        }

        return redirect()->router('users.index')->with('success', 'Succesfully deleted user ' . $name);
    }
}