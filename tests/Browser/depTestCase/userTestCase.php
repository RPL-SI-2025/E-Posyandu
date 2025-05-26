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
        $browser->loginAs(User::first()) // pastikan login sebagai admin
            ->visit('/admin/user/create')
            ->assertSee('Tambah Pengguna Baru')
            ->waitFor('#name')

            ->type('name', 'Test User')
            ->type('email', 'testuser@example.com')
            ->type('password', 'password123')
            ->type('password_confirmation', 'password123')
            ->select('role', 'petugas')
            ->type('phone', '08123456789')
            ->type('address', 'Jl. Testing no. 1')

            ->screenshot('before-press-simpan')
            ->press('Simpan')
            ->pause(2000)
            ->screenshot('after-press-simpan')

            // ✅ Jika berhasil, redirect ke index
            ->assertPathBeginsWith('/admin/user') // lebih fleksibel
            ->assertSee('Pengguna berhasil ditambahkan'); // pastikan flash message ada
    });
}


public function test_edit_user_by_id_2()
{
    $user = \App\Models\User::find(2);
    $this->assertNotNull($user, 'User dengan ID 2 tidak ditemukan.');

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs(User::first()) // pastikan login sebagai admin
                ->visit("/admin/user/{$user->id}/edit")
                ->type('name', 'Nama Baru User')
                ->type('email', 'updateuser@example.com')
                ->select('verifikasi', 'approved')
                ->select('role', 'petugas')
                ->press('Update')
                ->pause(1000)
                ->assertPathIs("/admin/user") // diasumsikan redirect ke index
                ->assertSee('Pengguna berhasil diperbarui'); // flash message biasa
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
}public function test_admin_can_search_users_by_name()
{
    $admin = \App\Models\User::where('role', 'admin')->first();
    $this->assertNotNull($admin, 'User dengan role admin tidak ditemukan.');

    $this->browse(function (Browser $browser) use ($admin) {
        $searchTerm = 'uktii';

        $browser->loginAs($admin)
            ->visit('/user')

            // Tunggu sampai input pencarian muncul
            ->waitFor('input[name="search"]')
            ->pause(1000)

            // Ketik kata pencarian
            ->type('search', $searchTerm)
            ->pause(1000)

            // Pastikan input sudah benar
            ->assertInputValue('search', $searchTerm)

            // Tekan tombol "Cari"
            ->press('Cari')
            ->pause(2000)

            // Screenshot untuk memverifikasi kondisi halaman
            ->screenshot('after-search-by-name')

            // Cek bahwa hasil pencarian muncul di halaman
            ->assertSee($searchTerm)

            // Cek bahwa hasil muncul di tabel (pakai dusk selector jika ada)
            ->within('@user-table', function ($table) use ($searchTerm) {
                $table->assertSee($searchTerm);
            })

            ->pause(1000);
    });
}



}
