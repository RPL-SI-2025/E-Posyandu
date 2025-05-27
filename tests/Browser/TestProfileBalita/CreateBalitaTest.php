<?php

namespace Tests\Browser\TestProfileBalita;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateBalitaTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testNormalCaseTambahBalita(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'rinipuspita@gmail.com')
                    ->type('password', 'rinipuspita')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(500)
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->clickLink('Tambah Anak')
                    ->assertPathIs('/orangtua/profiles/create')
                    ->assertSee('Tambah Data Anak')
                    ->pause(500)
                    ->type('nama_anak', 'Budi Santoso')
                    ->type('tanggal_lahir', '15-05-2023')
                    ->select('jenis_kelamin', 'laki-laki') 
                    ->type('nik', '1234567890123456')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/profiles')
                    ->assertSee('Anak berhasil ditambahkan.');
        });
    }

    public function testExceptionCaseTambahBalita(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'rinipuspita@gmail.com')
                    ->type('password', 'rinipuspita')
                    ->press('Login')
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(500)
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->clickLink('Tambah Anak')
                    ->assertPathIs('/orangtua/profiles/create')
                    ->assertSee('Tambah Data Anak')
                    ->pause(500)
                    ->type('tanggal_lahir', '')
                    ->select('jenis_kelamin', '') 
                    ->type('nik', '')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/profiles/create');
        });
    }
}
