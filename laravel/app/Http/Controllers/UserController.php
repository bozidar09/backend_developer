<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Rental;
use App\Models\User;
use App\Services\MembershipService;
use App\Services\RentalCalculatorService;
use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['rentals'])->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(UserRequest $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'], // Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required',
        ]);

        // $users = User::all();
        // $values = range(10000, 99999);

        // foreach ($users as $user) {
        //     $taken = str_replace('user-', '', $user);
        //     if (($key = array_search($taken, $values)) !== false) {
        //         unset($values[$key]);
        //     }
        // }
        // $data['member_id'] = 'user-' . $values[array_rand($values)];

        $data['member_id'] = (new MembershipService())->generate();

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Uspješno spremljen korisnik ' . $data['first_name'] . ' ' . $data['last_name']);
    }


    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with(['rentals'])->first();

        $rentals = Rental::where('user_id', $user->id)->whereNull('return_date')->with('user', 'copies.format', 'copies.movie.price', 'copies.movie.genre')->get();

        foreach ($rentals as $rental) {
            $rental = (new RentalCalculatorService())->calculate($rental);
        }

        return view('admin.users.show', compact('user', 'rentals'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(UserRequest $request, User $user)
    { 
        $data = $request->validate([
            'member_id' => ['required', 'string', Rule::unique('users')->ignore($user)],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'password' => ['required', 'confirmed'], // Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Uspješno izmijenjen član ' . $data['first_name'] . ' ' . $data['last_name']);
    }

 
    public function destroy(User $user)
    {
        $name = $user['first_name'] . ' ' . $user['last_name'];
        try {
            $user->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati korisnika prije nego obrišete vezane posudbe');
        }

        return redirect()->route('users.index')->with('success', 'Uspješno obrisan korisnik ' . $name);
    }
}
