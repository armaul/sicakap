<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    protected function getActiveUser(): User
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $activeUser = $this->getActiveUser();
        $allUsers = User::orderBy('role')->orderBy('name')->get();
        $shifts = Shift::all();

        // Personal roster schedule for this active user
        $mySchedules = \App\Models\UserSchedule::with('shift')
            ->where('user_id', $activeUser->id)
            ->where('date', '>=', \Carbon\Carbon::today()->startOfMonth())
            ->where('date', '<=', \Carbon\Carbon::today()->endOfMonth())
            ->orderBy('date', 'asc')
            ->get();

        return view('shifts.index', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
            'shifts' => $shifts,
            'mySchedules' => $mySchedules,
        ]);
    }
}
