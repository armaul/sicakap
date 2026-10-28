<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');

        $query = User::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($role && in_array($role, ['satpam', 'caraka', 'supervisor', 'admin'])) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();

        // Metric stats
        $totalUsers = User::count();
        $totalSatpam = User::where('role', 'satpam')->count();
        $totalCaraka = User::where('role', 'caraka')->count();
        $totalAdmin = User::whereIn('role', ['admin', 'supervisor'])->count();

        return view('admin.users.index', [
            'activeUser' => Auth::user(),
            'allUsers' => User::all(),
            'users' => $users,
            'search' => $search,
            'selectedRole' => $role,
            'stats' => [
                'total' => $totalUsers,
                'satpam' => $totalSatpam,
                'caraka' => $totalCaraka,
                'admin' => $totalAdmin,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:users,nip',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:satpam,caraka,supervisor,admin',
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6',
        ]);

        $defaultAvatars = [
            'satpam' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
            'caraka' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
            'supervisor' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&auto=format&fit=crop&q=80',
            'admin' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
        ];

        User::create([
            'name' => $validated['name'],
            'nip' => strtoupper($validated['nip']),
            'email' => strtolower($validated['email']),
            'role' => $validated['role'],
            'position' => $validated['position'],
            'phone' => $validated['phone'],
            'avatar' => $defaultAvatars[$validated['role']] ?? $defaultAvatars['satpam'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun personil {$validated['name']} ({$validated['nip']}) berhasil ditambahkan ke sistem.");
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => 'required|in:satpam,caraka,supervisor,admin',
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'nip' => strtoupper($validated['nip']),
            'email' => strtolower($validated['email']),
            'role' => $validated['role'],
            'position' => $validated['position'],
            'phone' => $validated['phone'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Administrator yang sedang aktif digunakan.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun pengguna {$userName} telah berhasil dihapus dari sistem.");
    }
}
