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
                    ->type('email', 'orangtua@gmail.com')
                    ->type('password', 'orangtua')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(1000)
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->pause(1000)
                    ->click('@button-view', 17)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles/17')
                    ->assertSee('Perkembangan Anak');
        });
    }
}
