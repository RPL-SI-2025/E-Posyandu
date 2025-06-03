<?php

namespace Tests\Browser\TestProfileBalita;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EditBalitaTest extends DuskTestCase
{
    /**
     * Test Normal Case: User can successfully edit a balita with valid data for ID 3.
     */
    public function testNormalCaseEditBalita(): void
    {
        $user = User::where('email', 'orangtua@gmail.com')->first();

        if (!$user) {
            $this->fail('User orangtua@gmail.com not found in the database.');
        }

        $balita = DB::table('table_child')
                    ->where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->first();

        if (!$balita) {
            $this->fail('No balita found in the database. Please ensure there is at least one balita record.');
        }

        $balitaId = $balita->id;

        $this->browse(function (Browser $browser) use ($balitaId) {
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
                    ->click('@button-edit', 17)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles/17/edit')
                    ->assertSee('Edit Data Anak')
                    ->pause(500)
                    ->type('nama_anak', 'Adining Rini Puspita Sari')
                    ->type('tanggal_lahir', '15-05-2023')
                    ->select('jenis_kelamin', 'laki-laki')
                    ->type('nik', '9876543210123456')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/profiles')
                    ->assertSee('Data anak berhasil diperbarui.');
        });
    }

    /**
     * Test Exception Case: Editing balita fails with invalid data for ID 3.
     */
    public function testExceptionCaseEditBalitaInvalidData(): void
    {
        $user = User::where('email', 'orangtua@gmail.com')->first();

        if (!$user) {
            $this->fail('User orangtua@gmail.com not found in the database.');
        }

        $balita = DB::table('table_child')
                    ->where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->first();

        if (!$balita) {
            $this->fail('No balita found in the database. Please ensure there is at least one balita record.');
        }

        $balitaId = $balita->id;

        $this->browse(function (Browser $browser) use ($balitaId) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'orangtua@gmail.com')
                    ->type('password', "orangtua")
                    ->press('Login')
                    ->pause(500)
                    ->assertPathIs('/orangtua/dashboard')
                    ->assertSee('Dashboard')
                    ->pause(1000)
                    ->visit('/orangtua/profiles')
                    ->assertSee('Profil Anak')
                    ->pause(1000)
                    ->click('@button-edit', 17)
                    ->pause(1000)
                    ->assertPathIs('/orangtua/profiles/17/edit')
                    ->assertSee('Edit Data Anak')
                    ->pause(500)
                    ->type('nama_anak', '')
                    ->type('tanggal_lahir', '')
                    ->select('jenis_kelamin', '')
                    ->type('nik', '')
                    ->click('@button-simpan')
                    ->assertPathIs('/orangtua/profiles/17/edit');
        });
    }
}
