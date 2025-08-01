<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.users.user-index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.user-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,opd,walidata',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('dashboard.users.user-show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('dashboard.users.user-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|string|in:admin,opd,walidata',
        ]);

        $user->update($request->only('name', 'email', 'alamat','nomor_telepon','role'));

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // dd($user->id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}

