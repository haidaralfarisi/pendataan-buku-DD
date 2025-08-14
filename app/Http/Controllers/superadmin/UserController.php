<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all(); // Ambil semua classroom untuk dropdown
        $users = User::with('classroom')->paginate(10);
        return view('superadmin.user.index', compact('users', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|digits_between:5,20|unique:users,nisn', // NISN wajib unik
            'classroom_id' => 'nullable|integer', // pastikan ada validasi classroom
            'role' => 'nullable|string|in:superadmin,orangtua',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|digits_between:5,20|unique:users,nisn,' . $user->id, // unik kecuali user ini
            'classroom_id' => 'nullable|integer',
            'role' => 'nullable|string|in:superadmin,orangtua',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
