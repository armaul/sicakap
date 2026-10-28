<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function switchUser(Request $request, $id)
    {
        $currentUser = Auth::user();
        $originalAdminId = session('original_admin_id');

        // Fitur ganti akun diperbolehkan bagi Administrator atau sesi simulasi Admin
        $isAuthorized = ($currentUser && $currentUser->isAdmin()) || 
            ($originalAdminId && User::where('id', $originalAdminId)->whereIn('role', ['admin', 'supervisor'])->exists());

        if (!$isAuthorized) {
            return redirect()->back()->with('error', 'Akses ditolak. Fitur ganti akun hanya dapat digunakan oleh Administrator.');
        }

        $targetUser = User::findOrFail($id);

        // Simpan admin asli jika belum pernah disimpan
        if (!session()->has('original_admin_id') && $currentUser && $currentUser->isAdmin()) {
            session(['original_admin_id' => $currentUser->id]);
        }

        // Jika beralih kembali ke admin asli, bersihkan session simulasi
        if (session('original_admin_id') == $targetUser->id) {
            session()->forget('original_admin_id');
        }

        Auth::login($targetUser);
        session(['active_user_id' => $targetUser->id]);

        return redirect()->back()->with('success', "Beralih ke akun: {$targetUser->name} ({$targetUser->position})");
    }
}
