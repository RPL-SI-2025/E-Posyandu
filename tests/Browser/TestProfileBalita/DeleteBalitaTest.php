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
                    ->type('email', 'orangtua@gmail.com')
                    ->type('password', 'orangtua')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(1000)
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->pause(1000)
                    ->click('@button-delete', 17)
                    ->pause(1000)
                    ->assertDialogOpened('Apakah Anda yakin ingin menghapus data anak ini?')  // Mengganti kode konfirmasi
                    ->acceptDialog()  // Menyelesaikan konfirmasi
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles')
                    ->assertSee('Data anak berhasil dihapus.');
        });
    }

    public function testExceptionCaseDeleteUnauthorizedBalita(): void
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
                    ->click('@button-delete')
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles');
        });
    }
}
