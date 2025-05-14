<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FuctionalTestCase extends DuskTestCase
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
                    ->type('email', 'maitsaluthfiyyah29@gmail.com')
                    ->type('password', 'maitsa29')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        
        });
    }

    public function test_create_inspection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/dashboard')
                    ->pause(2000)
                    ->assertSee('Kunjungan')
                    ->clickLink('Kunjungan')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan')
                    ->click('@create-inspection')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan/create')
                    ->select('table_child_id', '2')
                    ->select('user_id', '2')
                    ->type('tanggal_pemeriksaan', '01-05-2025')
                    ->type('berat_badan', 12)
                    ->type('tinggi_badan', 102)
                    ->type('lingkar_kepala', 50)
                    ->type('catatan', 'test')
                    ->select('eventtime_id', '1')
                    ->press('Simpan')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan');
        });
    }
    public function test_create_inspection_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/dashboard')
                    ->pause(2000)
                    ->assertSee('Kunjungan')
                    ->clickLink('Kunjungan')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan')
                    ->click('@create-inspection')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan/create')
                    ->select('table_child_id', '1')
                    ->select('user_id', '1')
                    ->type('tanggal_pemeriksaan', '01-06-2025')
                    ->type('berat_badan', 10)
                    ->type('tinggi_badan', 85)
                    ->type('lingkar_kepala', 43)
                    ->type('catatan', 'test')
                    ->press('Simpan')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan/create');
        });
    }
    public function test_edit_inspection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->click('@edit-inspection', '15')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan/15/edit')
                    ->type('berat_badan', 14)
                    ->press('Update')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan');
        });
    }
    public function test_delete_inspection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->click('@delete-inspection', '16')
                    ->acceptDialog()
                    ->pause(2000)
                    ->assertSee('Data pemeriksaan berhasil dihapus');
        });
    }
    
    public function test_filter_inspection_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->click('@filter-inspection')
                    ->type('tanggal_pemeriksaan', '01-05-2025')
                    ->press('Terapkan Filter')
                    ->pause(2000)
                    ->assertSee('01-05-2025');
        });
    }

    public function test_filter_inspection_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->click('@filter-inspection')
                    ->type('tanggal_pemeriksaan', '15-05-2025')
                    ->press('Terapkan Filter')
                    ->pause(2000)
                    ->assertSee('Belum ada data pemeriksaan');
        });
    }

    public function test_hapus_filter_inspection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->click('@filter-inspection')
                    ->type('tanggal_pemeriksaan', '15-05-2025')
                    ->press('Terapkan Filter')
                    ->pause(2000)
                    ->assertSee('Belum ada data pemeriksaan')
                    ->click('@filter-inspection')
                    ->click('@filter-delete')
                    ->pause(2000)
                    ->assertPathIs('/admin/kunjungan');
        });
    }

    public function test_searchbar_inspection_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->type('search', 'maitsa')
                    ->press('Search')
                    ->pause(2000)
                    ->assertSee('Belum ada data pemeriksaan');
        });
    }

    public function test_searchbar_inspection_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kunjungan')
                    ->pause(2000)
                    ->type('search', 'Dimas Wijaya')
                    ->press('Search')
                    ->pause(2000)
                    ->assertSee('Dimas Wijaya');
        });
    }

}
