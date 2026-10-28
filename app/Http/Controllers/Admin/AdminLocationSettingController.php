<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLocationSettingController extends Controller
{
    /**
     * Display the location geofencing settings page.
     */
    public function index(): View
    {
        $settings = Setting::getLocationSettings();

        return view('admin.location.index', [
            'activeUser' => auth()->user(),
            'allUsers' => \App\Models\User::all(),
            'settings' => $settings,
        ]);
    }

    /**
     * Update the location geofencing settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'office_name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'required|integer|min:10|max:100000',
            'is_enabled' => 'nullable|in:0,1',
        ]);

        Setting::set('location_office_name', trim($validated['office_name']));
        Setting::set('location_latitude', $validated['latitude']);
        Setting::set('location_longitude', $validated['longitude']);
        Setting::set('location_radius_meters', $validated['radius_meters']);
        Setting::set('location_restriction_enabled', $request->has('is_enabled') && $request->input('is_enabled') == '1' ? '1' : '0');

        return redirect()->route('admin.location.index')
            ->with('success', 'Pengaturan pembatasan radius lokasi absensi berhasil diperbarui!');
    }
}
