<?php

namespace Tests\Browser\TestReportDaily;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateReportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseAddReportDaily(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'rinipuspita@gmail.com')
                    ->type('password', 'rinipuspita')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(1000)
                    ->visit('/orangtua/reports')
                    ->assertSee('Report Daily')
                    ->clickLink('Tambah Report')
                    ->assertPathIs('/orangtua/reports/create')
                    ->assertSee('Tambah Report Daily')
                    ->select('child_id', 1)
                    ->type('tanggal', '15-05-2025')
                    ->type('judul_report', 'Laporan Harian Februari')
                    ->type('isi_report', 'Anak belajar menggambar hari ini.')
                    // ->attach('image', __DIR__.'/files/test-image.jpg')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/reports')
                    ->assertSee('Report Daily');
        });
    }

    public function testExceptionCaseAddReportDaily(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'rinipuspita@gmail.com')
                    ->type('password', 'rinipuspita')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(1000)
                    ->visit('/orangtua/reports')
                    ->assertSee('Report Daily')
                    ->clickLink('Tambah Report')
                    ->assertPathIs('/orangtua/reports/create')
                    ->assertSee('Tambah Report Daily')
                    ->select('child_id', 1)
                    ->type('tanggal', '')
                    ->type('judul_report', '')
                    ->type('isi_report', '')
                    // ->attach('image', __DIR__.'/files/test-image.jpg')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/reports/create');
        });
    }
}
