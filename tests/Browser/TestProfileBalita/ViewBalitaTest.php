<?php

namespace Tests\Browser\TestProfileBalita;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewBalitaTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseViewBalita(): void
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
                    ->click('@button-view', 1)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles/1')
                    ->assertSee('Perkembangan Anak');
        });
    }
}
