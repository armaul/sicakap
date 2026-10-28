<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    protected function getActiveUser(): User
    {
        return Auth::user();
    }

    /**
     * Tampilkan formulir edit profil untuk seluruh pengguna
     */
    public function edit()
    {
        $activeUser = $this->getActiveUser();
        $allUsers = User::orderBy('role')->orderBy('name')->get();

        return view('profile.edit', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
        ]);
    }

    /**
     * Simpan pembaruan profil pengguna
     */
    public function update(Request $request)
    {
        $activeUser = $this->getActiveUser();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($activeUser->id)],
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'avatar.image' => 'Berkas foto profil harus berupa file gambar valid.',
            'avatar.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto profil maksimal adalah 5 MB.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
        ]);

        $activeUser->name = $validated['name'];
        $activeUser->email = strtolower($validated['email']);
        $activeUser->phone = $validated['phone'];

        // Upload foto profil baru jika ada
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $activeUser->avatar = asset('storage/' . $path);
        }

        // Perbarui kata sandi jika diisi
        if (!empty($validated['password'])) {
            $activeUser->password = Hash::make($validated['password']);
        }

        $activeUser->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profil dan informasi akun Anda berhasil diperbarui.');
    }
}
