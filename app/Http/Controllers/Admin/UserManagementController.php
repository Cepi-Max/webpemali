<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    //
    function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->where('role', $role);
        }

        $users = $query->orderBy('name', 'asc')->paginate(9)->withQueryString();

        $users->appends($request->only(['search', 'role']));

        $data = [
            'title' => 'Pengaturan Pengguna',
            'users' => $users
        ];

        return view('admin.user-management.index', $data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'title' => 'Form Ubah Pengguna',
            'user' => $user
        ];

        return view('admin.user-management.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'number_phone' => 'required|string|max:20',
            'role'         => ['required', Rule::in(['admin', 'operator', 'citizen'])],
        ]);

        if (!$request->has('confirm_update')) {
            return back()->withErrors(['confirm_update' => 'Centang konfirmasi sebelum menyimpan perubahan.'])->withInput();
        }

        // Update semua kolom yang diperbolehkan
        $user->update([
            'name'         => $request->name,
            // 'nik'     => $request->nik,
            'email'        => $request->email,
            'number_phone' => $request->number_phone,
            'role'         => $request->role,
            // 'status'       => $request->status,
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        if ($authUser->role !== 'admin') {
            return back()->with('error', 'Kamu tidak memiliki izin untuk menghapus pengguna ini.');
        }

        if (!$request->has('confirm_delete')) {
            return back()->with('error', 'Silakan centang konfirmasi penghapusan terlebih dahulu.');
        }

        $user->delete();

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }


}
