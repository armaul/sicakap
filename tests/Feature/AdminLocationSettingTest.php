<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLocationSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default location settings
        Setting::set('location_office_name', 'SMKN 1 Jatisari (Kampus Utama)');
        Setting::set('location_latitude', '-6.3655');
        Setting::set('location_longitude', '107.5312');
        Setting::set('location_radius_meters', '100');
        Setting::set('location_restriction_enabled', '1');
    }

    public function test_guest_is_redirected_from_location_setting(): void
    {
        $response = $this->get('/admin/location-setting');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_location_setting(): void
    {
        $satpam = User::factory()->create([
            'role' => 'satpam',
        ]);

        $response = $this->actingAs($satpam)->get('/admin/location-setting');
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_location_setting(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/location-setting');
        $response->assertStatus(200);
        $response->assertSee('Setting Pembatasan Lokasi Maps');
        $response->assertSee('SMKN 1 Jatisari');
    }

    public function test_admin_can_update_location_settings(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/location-setting', [
            'office_name' => 'SMKN 1 Jatisari Pos Barat',
            'latitude' => -6.365512,
            'longitude' => 107.531245,
            'radius_meters' => 150,
            'is_enabled' => 1,
        ]);

        $response->assertRedirect(route('admin.location.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('SMKN 1 Jatisari Pos Barat', Setting::get('location_office_name'));
        $this->assertEquals(-6.365512, (float) Setting::get('location_latitude'));
        $this->assertEquals(107.531245, (float) Setting::get('location_longitude'));
        $this->assertEquals(150, (int) Setting::get('location_radius_meters'));
        $this->assertEquals('1', Setting::get('location_restriction_enabled'));
    }

    public function test_clock_in_is_rejected_when_outside_radius(): void
    {
        $satpam = User::factory()->create(['role' => 'satpam']);
        $shift = Shift::create([
            'name' => 'Shift Pagi',
            'code' => 'STP_PAGI_TEST',
            'role' => 'satpam',
            'start_time' => '07:00:00',
            'end_time' => '15:00:00',
            'grace_period_minutes' => 15,
        ]);

        // Lokasi jauh di luar radius (misal jarak 5000+ meter)
        $response = $this->actingAs($satpam)->postJson('/absen/masuk', [
            'shift_id' => $shift->id,
            'lat' => -6.3100, // Jauh dari -6.3655
            'lng' => 107.5312,
            'lokasi' => 'Di Rumah (Lat: -6.3100, Long: 107.5312)',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
        $response->assertJsonFragment([
            'success' => false,
        ]);
        $this->assertStringContainsString('di luar area', $response->json('message'));
    }

    public function test_clock_in_is_accepted_when_inside_radius(): void
    {
        $satpam = User::factory()->create(['role' => 'satpam']);
        $shift = Shift::create([
            'name' => 'Shift Pagi',
            'code' => 'STP_PAGI_TEST2',
            'role' => 'satpam',
            'start_time' => '07:00:00',
            'end_time' => '15:00:00',
            'grace_period_minutes' => 15,
        ]);

        // Lokasi sangat dekat (dalam 20 meter dari kantor)
        $response = $this->actingAs($satpam)->postJson('/absen/masuk', [
            'shift_id' => $shift->id,
            'lat' => -6.36551,
            'lng' => 107.53121,
            'lokasi' => 'Gerbang SMKN 1 Jatisari',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_clock_in_is_allowed_from_anywhere_when_geofencing_is_disabled(): void
    {
        // Nonaktifkan geofencing
        Setting::set('location_restriction_enabled', '0');

        $satpam = User::factory()->create(['role' => 'satpam']);
        $shift = Shift::create([
            'name' => 'Shift Pagi',
            'code' => 'STP_PAGI_TEST3',
            'role' => 'satpam',
            'start_time' => '07:00:00',
            'end_time' => '15:00:00',
            'grace_period_minutes' => 15,
        ]);

        // Lokasi jauh, tapi geofencing nonaktif
        $response = $this->actingAs($satpam)->postJson('/absen/masuk', [
            'shift_id' => $shift->id,
            'lat' => -6.2000,
            'lng' => 106.8166,
            'lokasi' => 'Remote Jakarta',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }
}
