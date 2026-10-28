<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminBackupTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdmin(): User
    {
        return User::where('role', 'admin')->first() ?? User::factory()->create([
            'nip' => 'ADM-001',
            'role' => 'admin',
        ]);
    }

    protected function getNonAdmin(): User
    {
        return User::where('role', '!=', 'admin')->first() ?? User::factory()->create([
            'nip' => 'STP-001',
            'role' => 'satpam',
        ]);
    }

    public function test_guest_cannot_access_backup_page(): void
    {
        $response = $this->get('/admin/backup');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_backup_page(): void
    {
        $user = $this->getNonAdmin();
        $response = $this->actingAs($user)->get('/admin/backup');
        // AdminMiddleware redirects non-admin to /
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_backup_page(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/backup');
        $response->assertStatus(200);
        $response->assertSee('Backup & Restore Data');
    }

    public function test_admin_can_export_backup_json(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/backup/export');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json; charset=UTF-8');
    }

    public function test_admin_can_export_backup_sql(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin/backup/export-sql');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/sql; charset=UTF-8');
    }

    public function test_admin_can_import_valid_backup_json(): void
    {
        $admin = $this->getAdmin();

        $payload = [
            'meta' => [
                'app' => 'SICAKAP',
                'version' => '1.0',
            ],
            'tables' => [
                'users' => [
                    [
                        'id' => $admin->id,
                        'nip' => $admin->nip,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'password' => $admin->password,
                        'role' => $admin->role,
                        'created_at' => (string) $admin->created_at,
                        'updated_at' => (string) $admin->updated_at,
                    ],
                ],
            ],
        ];

        $file = UploadedFile::fake()->createWithContent('backup.json', json_encode($payload));

        $response = $this->actingAs($admin)->post('/admin/backup/import', [
            'backup_file' => $file,
            'mode' => 'merge',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
