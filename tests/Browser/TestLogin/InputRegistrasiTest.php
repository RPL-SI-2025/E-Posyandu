<?php

namespace Tests\Browser\TestLogin;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class InputRegistrasiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseLoginSuccess(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'rinipuspita@gmail.com')
                    ->type('password', 'rinipuspita')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard');
        });
    }

    public function testExceptionCaseLoginFailure()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'emailpalsu@gmail.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }
}
