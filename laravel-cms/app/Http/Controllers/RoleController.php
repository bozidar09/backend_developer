<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
        ]);

        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'Succesfully stored role ' . $data['name']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role = Role::where('id', $role->id)->with('users')->first();

        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role = Role::where('id', $role->id)->first();

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('roles')->ignore($role)],
        ]);
        
        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Succesfully updated role ' . $data['name']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $name = $role->name;
        try {
            $role->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', "You cannot delete role before related users");
        }

        return redirect()->route('roles.index')->with('success', 'Succesfully deleted role ' . $name);
    }
}