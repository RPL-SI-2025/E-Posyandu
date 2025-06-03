<?php

namespace Tests\Browser\test_profilbayi_orangtua;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Child;
use App\Models\User;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\Facades\Log;

class BalitaTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Clean up any previous test children for the orangtua user
        $orangtuaUser = User::where('email', 'orangtua@gmail.com')->first();
        if ($orangtuaUser) {
            Child::where('user_id', $orangtuaUser->id)->delete();
        }
    }

    public function tearDown(): void
    {
        // Clean up test data created during tests (if any)
        $orangtuaUser = User::where('email', 'orangtua@gmail.com')->first();
        if ($orangtuaUser) {
            Child::where('user_id', $orangtuaUser->id)->delete();
        }
        parent::tearDown();
    }

    /**
     * Test login as orangtua user.
     */
    public function test_login_orangtua()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(1000)
                    ->assertSee('Login')
                    ->clickLink('Login')
                    ->pause(1000)
                    ->assertPathIs('/login')
                    ->type('email', 'orangtua@gmail.com')
                    ->type('password', 'orangtua') // Use the specified password
                    ->press('Login')
                    ->pause(1000) // Adjust pause if needed
                    ->assertPathIs('/orangtua/dashboard'); // Assert redirection to orangtua dashboard
        });
    }

    /**
     * Test viewing the Profil Balita list page in empty state as orangtua.
     * @depends test_login_orangtua
     */
    public function test_view_profil_balita_list_empty_state()
    {
        $this->browse(function (Browser $browser) {
             $browser->loginAs(User::where('email', 'orangtua@gmail.com')->first())
                    ->visit('/orangtua/profiles')
                    ->pause(2000) // Adjust pause if needed
                    ->assertSee('Profil Anak') // Assert main page title
                    ->assertSee('Daftar Anak') // Assert section header
                    ->assertSee('Anda belum memiliki data anak.') // Assert empty state message
                    ->assertSeeIn('a.btn-primary', 'Tambah Anak'); // Assert Tambah Anak link/button is present within the primary button link
        });
    }

    /**
     * Test navigating to the Tambah Data Anak page as orangtua.
     * @depends test_view_profil_balita_list_empty_state
     */
    public function test_navigate_to_add_balita_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email', 'orangtua@gmail.com')->first())
                    ->visit('/orangtua/profiles/create') // Visit the create page directly
                    ->pause(2000) // Adjust pause if needed for page load
                    ->assertPathIs('/orangtua/profiles/create') // Assert correct URL
                    ->assertSee('Tambah Data Anak') // Assert page title
                    ->assertSeeIn('label[for="nama_anak"]', 'Nama Anak') // Assert form field label
                    ->assertSeeIn('label[for="tanggal_lahir"]', 'Tanggal Lahir') // Assert form field label
                    ->assertSeeIn('label[for="jenis_kelamin"]', 'Jenis Kelamin') // Assert form field label
                    ->assertSeeIn('button[dusk="button-simpan"]', 'Simpan') // Assert Simpan button
                    ->assertSeeIn('a.btn-secondary', 'Batal'); // Assert Batal button
        });
    }

    /**
     * Test creating a new child with random data and performing CRUD operations.
     * @depends test_navigate_to_add_balita_page
     */
    public function test_create_child_with_random_data()
    {
        $faker = \Faker\Factory::create('id_ID');

        // Get the orangtua user first
        $orangtuaUser = User::where('email', 'orangtua@gmail.com')->first();
        $this->assertNotNull($orangtuaUser, 'Orangtua user not found in database');

        // Generate random data
        $namaAnak = $faker->firstName();
        // Generate a realistic date of birth within the last 5 years and up to one month ago
        // Manually generate a timestamp within the desired range and format it
        $startDate = strtotime('-5 years');
        $endDate = strtotime('-1 month');
        $randomTimestamp = mt_rand($startDate, $endDate);
        $tanggalLahir = date('Y-m-d', $randomTimestamp);
        $jenisKelamin = $faker->randomElement(['laki-laki', 'perempuan']);
        $nik = $faker->optional(0.7)->numerify('################'); // 70% chance to have NIK

        $this->browse(function (Browser $browser) use ($namaAnak, $tanggalLahir, $jenisKelamin, $nik, $orangtuaUser) {
            // Create child
            $browser->loginAs($orangtuaUser)
                    ->visit('/orangtua/profiles/create')
                    ->pause(1000)
                    ->type('nama_anak', $namaAnak)
                    ->type('tanggal_lahir', $tanggalLahir)
                    ->select('jenis_kelamin', $jenisKelamin);

            if ($nik) {
                $browser->type('nik', $nik);
            }

            // Debug: Log the form data before submission
            \Log::info('Submitting child data:', [
                'nama_anak' => $namaAnak,
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $jenisKelamin,
                'nik' => $nik,
                'user_id' => $orangtuaUser->id
            ]);

            $browser->press('Simpan')
                    ->pause(2000);

            // Debug: Check if we're on the correct page
            $currentPath = $browser->driver->getCurrentURL();
            \Log::info('Current URL after submission:', ['url' => $currentPath]);

            // After submission and redirect, assert that the child's name appears on the profiles list page
            $browser->assertPathIs('/orangtua/profiles')
                    ->assertSee($namaAnak);

            // Add a small pause before querying the database (optional, but can help in some environments)
            $browser->pause(500);

            // Get the child ID from the database with more specific query
            $child = \App\Models\Child::where([
                'nama_anak' => $namaAnak,
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $jenisKelamin,
                'nik' => $nik,
                'user_id' => $orangtuaUser->id
            ])->first();

            // Add more detailed assertion message
            $this->assertNotNull($child, sprintf(
                'Child data was not saved to database. Query params: nama_anak=%s, tanggal_lahir=%s, jenis_kelamin=%s, nik=%s, user_id=%s',
                $namaAnak,
                $tanggalLahir,
                $jenisKelamin,
                $nik,
                $orangtuaUser->id
            ));

            // View child development immediately after creation
            $browser->visit('/orangtua/profiles')
                    ->pause(2000)
                    ->assertPathIs('/orangtua/profiles')
                    ->assertSee($namaAnak)
                    ->click('@button-view')
                    ->pause(2000)
                    ->assertPathIs('/orangtua/profiles/' . $child->id)
                    ->assertSee('Perkembangan Anak')
                    ->assertSee($namaAnak)
                    ->assertSee('Informasi Anak')
                    ->assertSee('Riwayat Pemeriksaan')
                    ->assertSee('Belum ada data pemeriksaan untuk anak ini.');
        });
    }
}
