<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::withCount('attendances')->get();

        return view('admin.shifts.index', [
            'activeUser' => Auth::user(),
            'allUsers' => User::all(),
            'shifts' => $shifts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shifts,code',
            'role' => 'required|in:satpam,caraka,all',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_night_shift' => 'nullable|boolean',
            'grace_period_minutes' => 'required|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
        ]);

        Shift::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'role' => $validated['role'],
            'start_time' => $validated['start_time'] . ':00',
            'end_time' => $validated['end_time'] . ':00',
            'is_night_shift' => $request->boolean('is_night_shift'),
            'grace_period_minutes' => $validated['grace_period_minutes'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.shifts.index')
            ->with('success', "Shift kerja '{$validated['name']}' berhasil ditambahkan.");
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:50', Rule::unique('shifts', 'code')->ignore($shift->id)],
            'role' => 'required|in:satpam,caraka,all',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'is_night_shift' => 'nullable|boolean',
            'grace_period_minutes' => 'required|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
        ]);

        $startTime = strlen($validated['start_time']) === 5 ? $validated['start_time'] . ':00' : $validated['start_time'];
        $endTime = strlen($validated['end_time']) === 5 ? $validated['end_time'] . ':00' : $validated['end_time'];

        $shift->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'role' => $validated['role'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_night_shift' => $request->boolean('is_night_shift'),
            'grace_period_minutes' => $validated['grace_period_minutes'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.shifts.index')
            ->with('success', "Jadwal shift '{$shift->name}' berhasil diperbarui.");
    }

    public function destroy(Shift $shift)
    {
        if ($shift->attendances()->count() > 0) {
            return back()->with('error', "Shift '{$shift->name}' tidak dapat dihapus karena sudah memiliki riwayat presensi yang terkait.");
        }

        $shiftName = $shift->name;
        $shift->delete();

        return redirect()->route('admin.shifts.index')
            ->with('success', "Shift '{$shiftName}' telah berhasil dihapus.");
    }
}
