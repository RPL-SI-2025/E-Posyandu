<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;

class UserTestCase extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_login_admin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(2000)
                    ->assertSee('Login')
                    ->clickLink('Login')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->type('email', 'deviherminasilaban@gmail.com')
                    ->type('password', 'Uktiukti01')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        
        });
    }
public function test_view_user_index()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/user') // sesuaikan route jika berbeda
                ->assertSee('Daftar Pengguna')
                ->assertSee('Tambah Akun')
                ->assertVisible('table')
                ->pause(1000);
    });
}public function test_create_new_user()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/user/create')
                ->assertSee('Tambah Pengguna Baru')
                ->pause(1000)
                ->type('name', 'Test User')
                ->pause(500)
                ->type('email', 'testuser@example.com')
                ->pause(500)
                ->type('password', 'password123')
                ->pause(500)
                ->type('password_confirmation', 'password123')
                ->pause(500)
                ->select('role', 'petugas')
                ->pause(500)
                ->type('phone', '08123456789')
                ->pause(500)
                ->type('address', 'Jl. Testing no. 1')
                ->pause(500)
                ->press('Simpan')
                ->screenshot('after-press-simpan')
                ->dump()
                ->pause(2000)
                ->assertPathIs('/user')
                ;
    });
}public function test_edit_user_by_id_2()
{
    // Ambil user dengan ID 2
    $user = \App\Models\User::find(2);
    $this->assertNotNull($user, 'User dengan ID 2 tidak ditemukan');

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs(User::where('role', 'admin')->first()) // pastikan login sebagai admin
                ->visit("/user/{$user->id}/edit") // buka halaman edit user tersebut
                ->type('name', 'Nama Baru User')
                ->type('email', 'updateuser@example.com')
                ->select('verifikasi', 'approved') // sesuai dengan name="verifikasi" di form
                ->select('role', 'petugas') // contoh: ganti role ke petugas
                ->press('Update') // tombol submit
                ->pause(1000)
                ->assertPathIs('/user') // biasanya redirect ke index setelah update
                ->assertSee('Pengguna berhasil diperbarui'); // pastikan ada flash message muncul
    });
}
public function test_delete_user()
{
    $user = \App\Models\User::where('email', 'testuser@example.com')->first();
    $this->assertNotNull($user, 'User tidak ditemukan');

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit('/user')
            ->pause(1000)
            ->waitFor("@dropdown-{$user->id}", 10)
            ->click("@dropdown-{$user->id}") // klik titik 3 dulu
            ->pause(500)
            ->waitFor("@delete-{$user->id}", 10) // tunggu tombol delete muncul
            ->screenshot("before-click-delete")
            ->click("@delete-{$user->id}")
            ->pause(500)
            ->acceptDialog() // konfirmasi browser
            ->pause(1500)
            ->assertDontSee($user->name)
            ->screenshot("after-delete-user");
    });
}

public function test_admin_can_filter_users_by_role_petugas()
{
    $admin = \App\Models\User::where('role', 'admin')->first();
    $this->assertNotNull($admin, 'Admin user tidak ditemukan');

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
                ->visit('/user')
                ->pause(1000)
                ->select('role', 'petugas')
                ->pause(2000)
                ->assertQueryStringHas('role', 'petugas')
                ->assertSee('Petugas')
                ->assertDontSeeIn('table tbody', 'Admin')
                ->assertDontSeeIn('table tbody', 'Orangtua');
    });
}public function test_admin_can_filter_users_by_verifikasi_status()
{
    $admin = \App\Models\User::where('role', 'admin')->first();
    $this->assertNotNull($admin, 'Admin user tidak ditemukan');

    $this->browse(function (Browser $browser) use ($admin) {
        $statusLabels = [
            'waiting'  => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];

        foreach ($statusLabels as $status => $label) {
            $browser->loginAs($admin)
                ->visit('/user')
                ->pause(1000)
                ->select('verifikasi', $status)
                ->pause(1500)
                ->waitForText($label, 5) // pastikan teks muncul
                ->assertQueryStringHas('verifikasi', $status)
                ->assertSeeIn('table tbody', $label)
                ->screenshot("filter-status-{$status}");

            // Pastikan status lain tidak muncul
            foreach ($statusLabels as $otherStatus => $otherLabel) {
                if ($otherStatus !== $status) {
                    $browser->assertDontSeeIn('table tbody', $otherLabel);
                }
            }
        }
    });
}




public function test_admin_can_search_users_by_name()
{
    $admin = \App\Models\User::where('role', 'admin')->first();
    $this->assertNotNull($admin, 'User dengan role admin tidak ditemukan.');

    $this->browse(function (Browser $browser) use ($admin) {
        $searchTerm = 'uktii';

        $browser->loginAs($admin)
            ->visit('/user')
            ->type('search', $searchTerm)
            ->press('Cari') // pastikan tombol bertuliskan "Cari"
            ->pause(2000)
            ->assertInputValue('search', $searchTerm)
            ->assertSee($searchTerm)
            ->within('@user-table', function ($table) use ($searchTerm) {
                $table->assertSee($searchTerm);
            });
    });
}

}
