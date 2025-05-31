<?php

namespace Tests\Browser\TestProfileBalita;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteBalitaTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseDeleteBalita(): void
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
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->pause(1000)
                    ->click('@button-delete', 3)
                    ->pause(1000)
                    ->whenAvailable('#confirm-delete', function ($modal) {
                        $modal->press('OK');
                    })
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles')
                    ->assertSee('Data anak berhasil dihapus.');;
        });
    }

    public function testExceptionCaseDeleteUnauthorizedBalita(): void
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
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->pause(1000)
                    ->click('@button-delete')
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles');
        });
    }
}
