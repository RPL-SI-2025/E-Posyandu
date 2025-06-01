<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;

class UserTestCase4 extends DuskTestCase
{
    public function test_login_petugas()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(2000)
                ->assertSee('Login')
                ->clickLink('Login')
                ->pause(2000)
                ->assertPathIs('/login')
                ->type('email', 'abigailnapitu@gmail.com')
                ->type('password', 'napitupuluh')
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/petugas/dashboard');
        });
    

}public function test_petugas_create_user_orangtua()
{
    $this->browse(function (Browser $browser) {
        $petugas = User::where('email', 'abigailnapitu@gmail.com')->first();

        $browser->loginAs($petugas)
            ->visit(route('dashboard.petugas.user.create'))
            ->type('name', 'Rini pasaribu')
            ->type('email', 'Rinipasaribu'.time().'@egmail.com')  // unik pakai timestamp
            ->type('password', 'password123')
            ->type('password_confirmation', 'password123')
            ->type('phone', '08123456789')
            ->type('address', 'Jl. Test Address')
            ->press('Buat Akun')
            ->pause(3000)
            ->assertPathIs(route('dashboard.petugas.user.index', [], false));

    });
}public function test_petugas_edit_user_orangtua()
{
    $this->browse(function (Browser $browser) {
        $petugas = User::where('email', 'abigailnapitu@gmail.com')->first();
        $user = User::where('name', 'Rini pasaribu')->latest()->first();

        $browser->loginAs($petugas)
            ->visit(route('dashboard.petugas.user.edit', $user->id))
            ->pause(2000)

            // Edit nama
            ->type('name', 'Angelika Marbun')
            ->pause(1000)

            // Edit verifikasi (status_akun)
            ->select('status_akun', 'approved')
            ->pause(1000)

            // Simpan
            ->press('Update')
            ->pause(3000)

            // Verifikasi kembali ke halaman index
            ->assertPathIs(route('dashboard.petugas.user.index', [], false))
            ->assertSee('Angelika Marbun')
            ->pause(2000); // Jeda terakhir supaya kamu bisa lihat perubahan di UI
    });
}public function test_petugas_delete_user_()
{
    $this->browse(function (Browser $browser) {
        $petugas = User::where('email', 'abigailnapitu@gmail.com')->first();
        $user = User::where('name', 'Angelika Marbun')->latest()->first();

        $browser->loginAs($petugas)
            ->visit(route('dashboard.petugas.user.index'))
            ->pause(1000)
            ->click('[data-testid="dropdown-' . $user->id . '"]')
            ->pause(300)
            ->click('[data-testid="hapus-' . $user->id . '"]')
            ->pause(500)
            ->acceptDialog() // langsung accept confirm dialog
            ->pause(2000)
            ->assertDontSee($user->name);
    });
}

}





    
