<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    protected function getActiveUser(): User
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $activeUser = $this->getActiveUser();
        $allUsers = User::orderBy('role')->orderBy('name')->get();

        $category = $request->get('category');
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));

        $query = ActivityLog::with('user')->whereDate('created_at', $date);

        if ($category) {
            $query->where('category', $category);
        }

        if (!$activeUser->isSupervisor() && $request->get('all') !== '1') {
            $query->where('user_id', $activeUser->id);
        }

        $activities = $query->latest()->paginate(20);

        return view('activities.index', [
            'activeUser' => $activeUser,
            'allUsers' => $allUsers,
            'activities' => $activities,
            'selectedDate' => $date,
            'selectedCategory' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ], [
            'photo.required' => 'Foto bukti kegiatan wajib diunggah.',
            'photo.image' => 'Berkas yang diunggah harus berupa file gambar valid.',
            'photo.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal adalah 10 MB.',
        ]);

        $activeUser = $this->getActiveUser();
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('activities', 'public');
            $photoPath = asset('storage/' . $path);
        }

        ActivityLog::create([
            'user_id' => $activeUser->id,
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'description' => $request->description,
            'status' => 'Selesai',
            'photo' => $photoPath,
            'time_recorded' => Carbon::now()->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Catatan kegiatan berhasil disimpan ke logbook lengkap dengan foto bukti.');
    }
}
