<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;

class UserTestCase3 extends DuskTestCase
{
    public function test_login_petugas()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(2000)
                ->assertSee('Login')
                ->clickLink('Login')
                ->pause(2000)
                ->assertPathIs('/login')
                ->type('email', 'abigailnapitu@gmail.com')
                ->type('password', 'napitupuluh')
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/petugas/dashboard');
        });
    }public function test_petugas_filter_verifikasi_berurutan()
{$this->browse(function (Browser $browser) {
    $browser->loginAs(User::where('email', 'abigailnapitu@gmail.com')->first())
        ->visit(route('dashboard.petugas.user.index'))
        ->pause(2000)
        ->select('verifikasi', 'approved')
        ->pause(3000) // tunggu reload data otomatis
        ->assertSee('Disetujui')

        ->select('verifikasi', 'rejected')
        ->pause(3000)
        ->assertSee('Ditolak')

        ->select('verifikasi', 'waiting')
        ->pause(3000)
        ->assertSee('Menunggu')

        ->screenshot('filter-verifikasi-live-update');
});

}public function test_petugas_mencari_pengguna_berdasarkan_nama_dan_email_dengan_tombol_cari()
{
    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::where('email', 'abigailnapitu@gmail.com')->first())
            ->visit(route('dashboard.petugas.user.index'))
            
            // Cari berdasarkan Nama "elshaa"
            ->type('search', 'elshaa')
            ->pause(3000)              // tunggu reload data
            ->press('Cari')            // klik tombol cari
            ->pause(4000)              // tunggu hasil pencarian muncul
            ->assertSee('elshaa')      // pastikan nama tampil
            ->assertDontSee('malaikhajamal@gmail.com') // pastikan email lain tidak muncul
            
            // Clear input search sebelum cari email
            ->clear('search')
            ->pause(1000)
            
            // Cari berdasarkan Email "malaikhajamal@gmail.com"
            ->type('search', 'malaikhajamal@gmail.com')
            ->pause(2000)              // jeda ketik
            ->press('Cari')            // klik tombol cari
            ->pause(4000)              // tunggu reload hasil
            ->assertSee('malaikhajamal@gmail.com') // pastikan email tampil
            ->assertDontSee('elshaa')  // pastikan nama lain tidak muncul
            
            ->screenshot('cari-berdasarkan-nama-dan-email-dengan-tombol-cari');
    });
}

}