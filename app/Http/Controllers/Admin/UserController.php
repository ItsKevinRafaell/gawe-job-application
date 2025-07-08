<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        // Ambil semua pengguna dengan role 'project_client' untuk ditampilkan
        $users = User::role('project_client')->orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Memverifikasi sebuah bisnis lokal.
     */
    public function verifyBusiness(User $user)
    {
        // Pastikan hanya admin yang bisa mengakses (ini bisa diperkuat dengan middleware)
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES');
        }

        // Update status verifikasi pengguna
        $user->update(['is_verified_local_business' => true]);

        // Redirect kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Bisnis berhasil diverifikasi!');
    }
}
