<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventtimeTestCase extends DuskTestCase
{

    public function test_login_admin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(2000)
                    ->assertSee('Login')
                    ->clickLink('Login')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->type('email', 'salwa.ockryyy@gmail.com')
                    ->type('password', '12345678')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        
        });
    }

    /** @test */
    public function view_eventtime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/dashboard')
                    ->pause(2000)   
                    ->assertSee('Jadwal Kegiatan')
                    ->clickLink('Jadwal Kegiatan')
                    ->pause(2000)
                    ->assertPathIs('/eventtime');
            
        });
    }

    /** @test */
    public function create_eventtime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/eventtime')
                    ->pause(2000)
                    ->assertSee('Tambah Jadwal')
                    ->clickLink('Tambah Jadwal')
                    ->pause(2000)
                    ->assertPathIs('/eventtime/create')
                    ->type('tanggal', '30-05-2025')
                    ->type('jam_mulai', '09:00')
                    ->type('jam_selesai', '10:30')
                    ->type('lokasi', 'Posyandu Mawar')
                    ->type('keterangan', 'Vaksinasi Anak')
                    ->click('@button_simpan')
                    ->pause(2000)
                    ->assertPathIs('/eventtime');
        });
    }

    /** @test */
    public function edit_eventtime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/eventtime')
                    ->pause(2000)
                    ->assertSee('Edit')
                    ->clickLink('Edit')
                    ->pause(2000)
                    ->assertPathIs('/eventtime/1/edit')
                    ->type('tanggal', '30-05-2025')
                    ->type('jam_mulai', '10:00')
                    ->type('jam_selesai', '12:00')
                    ->type('lokasi', 'Posyandu Mawar')
                    ->type('keterangan', 'Vaksinasi Anak')
                    ->click('@button_simpan')
                    ->pause(2000)
                    ->assertPathIs('/eventtime');
        });
    }

    /** @test */
    public function delete_eventtime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/eventtime')
                    ->pause(2000)
                    ->assertSee('Delete')
                    ->clickLink('Delete')
                    ->pause(2000)
                    ->assertPathIs('/eventtime');
        });
    }
    
}