<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    protected function getActiveUser(): User
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $activeUser = $this->getActiveUser();
        $allUsers = User::orderBy('role')->orderBy('name')->get();

        // If supervisor, show all requests or filtered; else show current user's requests
        $query = LeaveRequest::with(['user', 'approver'])->latest();

        if (!$activeUser->isSupervisor()) {
            $query->where('user_id', $activeUser->id);
        }

        $leaveRequests = $query->paginate(15);

        // Stats for cards
        $pendingCount = LeaveRequest::where('status', 'Menunggu')->count();
        $approvedCount = LeaveRequest::where('status', 'Disetujui')->count();
        $rejectedCount = LeaveRequest::where('status', 'Ditolak')->count();

        return view('leave.index', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
            'leaveRequests' => $leaveRequests,
            'stats' => [
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'rejected' => $rejectedCount,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Sakit,Izin,Cuti,Dinas Luar',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'alasan' => 'required|string|max:1000',
            'surat_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,webp|max:5120',
            'surat_base64' => 'nullable|string',
        ]);

        $activeUser = $this->getActiveUser();
        $suratPath = null;

        // Process file upload or captured webcam photo
        if ($request->hasFile('surat_file')) {
            $file = $request->file('surat_file');
            $filename = 'surat_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('surat_izin', $filename, 'public');
            $suratPath = asset('storage/' . $path);
        } elseif ($request->filled('surat_base64')) {
            $base64 = $request->surat_base64;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $ext = strtolower($type[1]);
            } else {
                $ext = 'jpg';
            }
            $filename = 'surat_' . time() . '_' . rand(100, 999) . '.' . $ext;
            Storage::disk('public')->put('surat_izin/' . $filename, base64_decode($base64));
            $suratPath = asset('storage/surat_izin/' . $filename);
        }

        LeaveRequest::create([
            'user_id' => $activeUser->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'alasan' => $request->alasan,
            'surat_bukti' => $suratPath,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('leave.index')->with('success', 'Pengajuan ' . $request->type . ' berhasil dikirim dan menunggu verifikasi.');
    }

    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_atasan' => 'nullable|string|max:500',
        ]);

        $activeUser = $this->getActiveUser();

        $leave->update([
            'status' => $request->status,
            'catatan_atasan' => $request->catatan_atasan,
            'approved_by' => $activeUser->id,
        ]);

        return redirect()->route('leave.index')->with('success', 'Status pengajuan ' . $leave->user->name . ' telah diubah menjadi: ' . $request->status);
    }

    public function destroy(LeaveRequest $leave)
    {
        $activeUser = $this->getActiveUser();

        if ($leave->user_id !== $activeUser->id && !$activeUser->isSupervisor()) {
            return back()->with('error', 'Anda tidak memiliki hak untuk membatalkan pengajuan ini.');
        }

        if ($leave->status !== 'Menunggu' && !$activeUser->isSupervisor()) {
            return back()->with('error', 'Hanya pengajuan yang berstatus Menunggu yang dapat dibatalkan.');
        }

        $leave->delete();
        return back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}
