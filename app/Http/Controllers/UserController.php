<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $search = $request->get('search', '');

        // Daftar kolom yang diizinkan untuk sorting
        $allowedColumns = ['name', 'email', 'role', 'created_at'];

        // Validasi kolom sorting
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }

        // Validasi arah sorting
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

        // Query dengan pencarian
        $query = User::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy($sortBy, $sortDirection)->get();

        // Jika request AJAX, kembalikan JSON
        if ($request->ajax()) {
            return response()->json([
                'users' => $users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'plain_password' => $user->plain_password ?? 'N/A',
                        'created_at' => \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM Y'),
                    ];
                }),
                'count' => $users->count(),
                'search' => $search,
                'sortBy' => $sortBy,
                'sortDirection' => $sortDirection,
            ]);
        }

        return view('dashboard.users.user-index', compact('users', 'sortBy', 'sortDirection', 'search'));
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
            'plain_password' => $request->password, // ⚠️ Simpan password asli (tidak aman!)
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', // nullable: boleh kosong, tapi jika diisi min 8
            'role' => 'required|string|in:admin,opd,walidata',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'alamat','nomor_telepon','role');

        // Jika password diubah, update juga plain_password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
            $data['plain_password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // dd($user->id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function resetPassword(User $user)
    {
        // Generate password default atau random
        $newPassword = 'password123'; // Password default
        // Atau gunakan: $newPassword = \Str::random(8); untuk password random

        $user->update([
            'password' => bcrypt($newPassword),
            'plain_password' => $newPassword,
        ]);

        return redirect()->back()->with('success', 'Password berhasil direset menjadi: ' . $newPassword);
    }
}

