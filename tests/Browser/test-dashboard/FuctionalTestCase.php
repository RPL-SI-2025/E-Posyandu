<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FuctionalTestCase extends DuskTestCase
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
                    ->type('email', 'maitsaluthfiyyah29@gmail.com')
                    ->type('password', 'maitsa29')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        
        });
    }

    public function test_count_account()
    {
        $this->browse(function (Browser $browser) {
            // Hitung data dari database
            $waitingCount = \App\Models\User::where('verifikasi', 'waiting')->count();
            $approvedCount = \App\Models\User::where('verifikasi', 'approved')->count();
            $rejectedCount = \App\Models\User::where('verifikasi', 'rejected')->count();

    
            $browser->visit('/admin/dashboard')
                ->pause(2000)
                ->assertSeeIn('#count-disetujui', (string) number_format($approvedCount))
                ->assertSeeIn('#count-ditolak', (string) number_format($rejectedCount))
                ->assertSeeIn('#count-menunggu', (string) number_format($waitingCount));
            });
    }

    public function test_count_account_update()
    {
        $this->browse(function (Browser $browser) {
            $admin = \App\Models\User::where('email', 'maitsaluthfiyyah29@gmail.com')->first();
            $user = \App\Models\User::first();

            // Hitung data sebelum update
            $approvedCountBefore = \App\Models\User::where('verifikasi', 'approved')->count();

            $browser->loginAs($admin)
                ->visit('/admin/user')
                ->pause(2000)
                ->click("@dropdown-{$user->id}")
                ->pause(2000)
                ->press("@verify-{$user->id}-approve")
                ->pause(2000)
                ->assertSee('Dashboard')
                ->clickLink('Dashboard')
                ->visit('/admin/dashboard') 
                ->pause(2000)
                ->screenshot('before-click-dropdown')
                ->assertSeeIn('#count-disetujui', (string) number_format($approvedCountBefore + 1))
                ->click("#logout-form")
                ->assertPathIs('/')
                ->screenshot('landingpage');
        });
    }

    
    public function test_count_account_petugas()
    {
        $this->browse(function (Browser $browser) {
            
            // Hitung data dari database
            $waitingCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'waiting')->count();
            $approvedCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'approved')->count();
            $rejectedCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'rejected')->count();

    
            $browser->visit('/')
                ->pause(2000)
                ->assertSee('Login')
                ->clickLink('Login')
                ->pause(2000)
                ->assertPathIs('/login')
                ->type('email', 'moses@gmail.com')
                ->type('password', '10akLIMA!')
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/petugas/dashboard')
                ->pause(2000)
                ->assertSeeIn('#count-disetujui', (string) number_format($approvedCount))
                ->assertSeeIn('#count-ditolak', (string) number_format($rejectedCount))
                ->assertSeeIn('#count-menunggu', (string) number_format($waitingCount));
            });
    }

    public function test_count_account_update_petugas()
    {
        $this->browse(function (Browser $browser) {
            $petugas = \App\Models\User::where('email', 'moses@gmail.com')->first();
            $user = \App\Models\User::first();

            // Hitung data sebelum update
            $waitingCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'waiting')->count();
            $approvedCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'approved')->count();
            $rejectedCount = \App\Models\User::where('role', 'orangtua')->where('verifikasi', 'rejected')->count();

            $browser->loginAs($petugas)
                ->visit('/petugas/user')
                ->pause(2000)
                ->click('[data-testid="dropdown-' . $user->id . '"]')
                ->pause(2000)
                ->press('[data-testid="verify-' . $user->id . '-approve"]')
                ->pause(2000)
                ->assertSee('Dashboard')
                ->clickLink('Dashboard')
                ->visit('/petugas/dashboard') 
                ->assertSeeIn('#count-disetujui', (string) number_format($approvedCount + 1))
                ->click("#logout-form")
                ->assertPathIs('/');
        });
    }

    

}
