<?php

namespace Tests\Browser\TestReportDaily;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditReportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
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
                    ->click('@button-edit', 1)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/reports/14/edit')
                    ->assertSee('Edit Report Daily')
                    ->type('tanggal', '18-05-2025')
                    ->type('judul_report', 'Laporan Harian Mei')
                    ->type('isi_report', 'Anak belajar menggambar hari ini dengan active')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/reports')
                    ->assertSee('Report Daily');
            ;
        });
    }

    public function testExceptionCaseEditReportDailyInvalidData(): void
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
                    ->click('@button-edit', 1)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/reports/14/edit')
                    ->assertSee('Edit Report Daily')
                    ->type('tanggal', '')
                    ->type('judul_report', '')
                    ->type('isi_report', '')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/reports/14/edit')
                    ->assertSee('Edit Report Daily')
            ;
        });
    }
}