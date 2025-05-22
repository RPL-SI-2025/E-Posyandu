<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class UserTestCase extends DuskTestCase
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
                    ->type('email', 'nurulahmadaja@gmail.com')
                    ->type('password', 'Debindebin')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        
        });
    }

   

}
