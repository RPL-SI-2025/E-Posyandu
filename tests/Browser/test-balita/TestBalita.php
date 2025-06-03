<?php

namespace Tests\Browser\test_balita;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Balita;
use App\Models\User;
use Carbon\Carbon;
use Facebook\WebDriver\WebDriverBy;

class TestBalita extends DuskTestCase
{
    /**
     * Test login as admin
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
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        });
    }

    /**
     * Test Create Balita (C)
     */
    public function test_create_balita()
    {
        $this->browse(function (Browser $browser) {
            // First login as admin
            $browser->visit('/login')
                    ->pause(2000)
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');

            $user = User::first();
            if (!$user) {
                $this->markTestSkipped('No user available for testing');
            }

            // Clean up existing test data to avoid unique constraint violation
            Balita::where('nik', '1234567890123457')->delete();

            $browser->visit('/admin/balita')
                    ->pause(2000)
                    ->assertSee('Data Balita')
                    ->waitFor('a[href*="balita/create"]')
                    ->click('a[href*="balita/create"]')
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/create')
                    ->waitFor('#user_id')
                    ->select('#user_id', $user->id)
                    ->type('nama_anak', 'Test Balita Baru')
                    ->type('nik', '1234567890123457')
                    ->type('tanggal_lahir', Carbon::now()->subYears(3)->format('Y-m-d'))
                    ->select('jenis_kelamin', 'laki-laki')
                    ->press('Simpan')
                    ->pause(5000)
                    ->assertPathIs('/admin/balita')
                    ->assertSee('Test Balita Baru');
        });
    }

    /**
     * Test Read Balita (R)
     */
    public function test_read_balita()
    {
        $this->browse(function (Browser $browser) {
            // First login as admin
            $browser->visit('/login')
                    ->pause(2000)
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');

            // Create a test balita if none exists
            $balita = Balita::first();
            if (!$balita) {
                $user = User::first();
                if (!$user) {
                    $this->markTestSkipped('No user available for testing');
                }
                
                $balita = Balita::create([
                    'user_id' => $user->id,
                    'nama_anak' => 'Test Balita Read',
                    'nik' => '1234567890123456',
                    'tanggal_lahir' => Carbon::now()->subYears(3),
                    'jenis_kelamin' => 'laki-laki'
                ]);
            }

            $browser->visit('/admin/balita')
                    ->pause(2000)
                    ->assertSee('Data Balita')
                    ->assertSee($balita->nama_anak)
                    ->assertSee($balita->nik)
                    ->waitFor("a[href*='balita/{$balita->id}']")
                    ->click("a[href*='balita/{$balita->id}']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $balita->id)
                    ->assertSee($balita->nama_anak)
                    ->assertSee($balita->nik)
                    ->assertSee(Carbon::parse($balita->tanggal_lahir)->format('d/m/Y'))
                    ->assertSee($balita->jenis_kelamin);
        });
    }

    /**
     * Test Update Balita (U)
     */
    public function test_update_balita()
    {
        $this->browse(function (Browser $browser) {
            // First login as admin
            $browser->visit('/login')
                    ->pause(2000)
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');

            // Create a test balita if none exists
            $balita = Balita::first();
            if (!$balita) {
                $user = User::first();
                if (!$user) {
                    $this->markTestSkipped('No user available for testing');
                }
                
                $balita = Balita::create([
                    'user_id' => $user->id,
                    'nama_anak' => 'Test Balita Update',
                    'nik' => '1234567890123455',
                    'tanggal_lahir' => Carbon::now()->subYears(3),
                    'jenis_kelamin' => 'laki-laki'
                ]);
            }

            $user = User::first();
            if (!$user) {
                $this->markTestSkipped('No user available for testing');
            }

            $browser->visit('/admin/balita')
                    ->pause(2000)
                    ->assertSee('Data Balita')
                    ->waitFor("a[href*='balita/{$balita->id}/edit']")
                    ->click("a[href*='balita/{$balita->id}/edit']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $balita->id . '/edit')
                    ->waitFor('#user_id')
                    ->select('#user_id', $user->id)
                    ->type('nama_anak', 'Balita Update Test')
                    ->type('nik', '1234567890123458')
                    ->type('tanggal_lahir', Carbon::now()->subYears(4)->format('Y-m-d'))
                    ->select('jenis_kelamin', 'perempuan')
                    ->press('Simpan')
                    ->pause(5000)
                    ->assertPathIs('/admin/balita')
                    ->assertSee('Balita Update Test')
                    ->assertSee('1234567890123458');
        });
    }

    /**
     * Test Delete Balita (D)
     */
    public function test_delete_balita()
    {
        $this->browse(function (Browser $browser) {
            // First login as admin
            $browser->visit('/login')
                    ->pause(2000)
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');

            // Create a test balita if none exists
            $balita = Balita::first();
            if (!$balita) {
                $user = User::first();
                if (!$user) {
                    $this->markTestSkipped('No user available for testing');
                }
                
                $balita = Balita::create([
                    'user_id' => $user->id,
                    'nama_anak' => 'Test Balita Delete',
                    'nik' => '1234567890123454',
                    'tanggal_lahir' => Carbon::now()->subYears(3),
                    'jenis_kelamin' => 'laki-laki'
                ]);
            }

            $browser->visit('/admin/balita')
                    ->pause(2000)
                    ->assertSee('Data Balita')
                    ->waitFor("a[href*='balita/{$balita->id}']")
                    ->click("a[href*='balita/{$balita->id}']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $balita->id)
                    ->waitFor('form[action*="balita/' . $balita->id . '"] button[type="submit"]')
                    ->click('form[action*="balita/' . $balita->id . '"] button[type="submit"]')
                    ->assertDialogOpened('Apakah Anda yakin ingin menghapus data ini?')
                    ->acceptDialog()
                    ->pause(3000)
                    ->assertPathIs('/admin/balita')
                    ->assertDontSee($balita->nama_anak);
        });
    }

    /**
     * Test Complete CRUD Flow
     */
    public function test_complete_crud_flow()
    {
        $this->browse(function (Browser $browser) {
            // First login as admin
            $browser->visit('/login')
                    ->pause(2000)
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');

            $user = User::first();
            if (!$user) {
                $this->markTestSkipped('No user available for testing');
            }

            // Clean up existing test data to avoid unique constraint violation
            Balita::where('nik', '1234567890123459')->delete();

            // Create
            $browser->visit('/admin/balita')
                    ->pause(2000)
                    ->assertSee('Data Balita')
                    ->waitFor('a[href*="balita/create"]')
                    ->click('a[href*="balita/create"]')
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/create')
                    ->waitFor('#user_id')
                    ->select('#user_id', $user->id)
                    ->type('nama_anak', 'Test CRUD Flow')
                    ->type('nik', '1234567890123459')
                    ->type('tanggal_lahir', Carbon::now()->subYears(3)->format('Y-m-d'))
                    ->select('jenis_kelamin', 'laki-laki')
                    ->press('Simpan')
                    ->pause(5000)
                    ->assertPathIs('/admin/balita')
                    ->assertSee('Test CRUD Flow');

            $browser->pause(2000);
            $newBalita = Balita::where('nama_anak', 'Test CRUD Flow')->first();
            if (!$newBalita) {
                $this->fail('Balita was not created successfully');
            }
            $newBalitaId = $newBalita->id;

            // Read
            $browser->waitFor("a[href*='balita/{$newBalitaId}']")
                    ->click("a[href*='balita/{$newBalitaId}']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $newBalitaId)
                    ->assertSee('Test CRUD Flow')
                    ->assertSee('1234567890123459');

            // Update
            $browser->waitFor("a[href*='balita/{$newBalitaId}/edit']")
                    ->click("a[href*='balita/{$newBalitaId}/edit']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $newBalitaId . '/edit')
                    ->waitFor('#user_id')
                    ->select('#user_id', $user->id)
                    ->type('nama_anak', 'Test CRUD Flow Updated')
                    ->type('nik', '1234567890123460')
                    ->type('tanggal_lahir', Carbon::now()->subYears(4)->format('Y-m-d'))
                    ->select('jenis_kelamin', 'perempuan')
                    ->press('Simpan')
                    ->pause(5000)
                    ->assertPathIs('/admin/balita')
                    ->assertSee('Test CRUD Flow Updated');

            // Delete
            $browser->waitFor("a[href*='balita/{$newBalitaId}']")
                    ->click("a[href*='balita/{$newBalitaId}']")
                    ->pause(2000)
                    ->assertPathIs('/admin/balita/' . $newBalitaId)
                    ->waitFor('form[action*="balita/' . $newBalitaId . '"] button[type="submit"]')
                    ->click('form[action*="balita/' . $newBalitaId . '"] button[type="submit"]')
                    ->assertDialogOpened('Apakah Anda yakin ingin menghapus data ini?')
                    ->acceptDialog()
                    ->pause(3000)
                    ->assertPathIs('/admin/balita')
                    ->assertDontSee('Test CRUD Flow Updated');
        });
    }
}
