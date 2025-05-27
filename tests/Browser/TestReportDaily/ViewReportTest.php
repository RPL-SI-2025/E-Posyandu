<?php

namespace Tests\Browser\TestReportDaily;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewReportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseViewReportDailyList(): void
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
                    ->assertSee('Report Daily');
        });
    }

    public function testExceptionCaseViewReportDailyList(): void
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
                    ->assertDontSee('Tidak ada data report')
                    ->assertDontSee('Laporan Harian Januari');
        });
    }
}
