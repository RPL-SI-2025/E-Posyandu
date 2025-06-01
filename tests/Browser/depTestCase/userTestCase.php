<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;

class UserTestCase extends DuskTestCase
{
    public function test_login_admin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(2000)
                ->assertSee('Login')
                ->clickLink('Login')
                ->pause(2000)
                ->assertPathIs('/login')
                ->type('email', 'nurulgeiufwedjwija@gmail.com')
                ->type('password', 'udahbisa01')
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/admin/dashboard');
        });
    }

    public function test_view_user_index()
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin, 'Admin user tidak ditemukan.');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/user')
                ->assertSee('Daftar Pengguna')
                ->assertSee('Tambah Akun')
                ->assertVisible('table')
                ->pause(1000);
        });
    }



    public function test_admin_can_filter_users_by_role_petugas()
    {
        $admin = User::where('role', 'admin')->first();
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
    }

    public function test_admin_can_filter_users_by_verifikasi_status()
    {
        $admin = User::where('role', 'admin')->first();
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
                    ->waitForText($label, 5)
                    ->assertQueryStringHas('verifikasi', $status)
                    ->assertSeeIn('table tbody', $label)
                    ->screenshot("filter-status-{$status}");

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
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin, 'Admin user tidak ditemukan.');

        $searchTerm = 'Uktii';

        $this->browse(function (Browser $browser) use ($admin, $searchTerm) {
            $browser->loginAs($admin)
                ->visit('/user')
                ->waitFor('input[name="search"]')
                ->pause(1000)
                ->type('search', $searchTerm)
                ->pause(1000)
                ->assertInputValue('search', $searchTerm)
                ->press('Cari')
                ->pause(2000)
                ->screenshot('after-search-by-name')
                ->assertSee($searchTerm)
                ->within('@user-table', function ($table) use ($searchTerm) {
                    $table->assertSee($searchTerm);
                })
                ->pause(1000);
        });
    }
}
