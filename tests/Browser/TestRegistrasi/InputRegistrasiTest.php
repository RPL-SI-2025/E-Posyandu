<?php

namespace Tests\Browser\TestRegistrasi;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class InputRegistrasiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Register')
                    ->clicklink('Register')
                    ->pause(1000)
                    ->type('name', 'John Doe')
                    ->type('email', 'john.doe@example.com')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->press('Register')
                    ->assertPathIs('/login');
        });
    }

    // Exception case: Invalid registration data and failed login attempt.
    public function testExceptionCaseRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Register')
                    ->clicklink('Register')
                    ->pause(1000)
                    ->type('name', '')
                    ->type('email', 'invalid-email')
                    ->type('phone', '081234579843')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('password', 'short')
                    ->type('password_confirmation', 'different-password')
                    ->press('Register')
                    ->assertSee('The name field is required.')
                    ->assertSee('The email must be a valid email address.')
                    ->assertSee('The password must be at least 8 characters.')
                    ->assertSee('The password confirmation does not match.')
                    ->assertPathIs('/register');
        });
    }
}
