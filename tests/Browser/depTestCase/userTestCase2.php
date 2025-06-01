<?php

namespace Tests\Browser\Inspection;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;

class UserTestCase2 extends DuskTestCase
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
                ->type('email', 'nurulgeiufwedjwija@gmail.com')
                ->type('password', 'udahbisa01')
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/admin/dashboard');
        });
    }

public function test_create_new_user()
{
    $admin = User::where('email', 'nurulgeiufwedjwija@gmail.com')->first();
    $this->assertNotNull($admin, 'Admin user tidak ditemukan.');

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit('/admin/user/create')
            ->assertSee('Tambah Pengguna Baru') // pastikan halaman benar
            ->waitFor('#name')
            ->type('name', 'User Untuk Dihapus')
            ->type('email', 'mikaadinar@gmail.com')
            ->type('password', 'password123')
            ->type('password_confirmation', 'password123')
            ->select('role', 'petugas')
            ->type('phone', '08777777777')
            ->type('address', 'Jl. Delete Me')
            ->screenshot('create-before-submit')
            ->press('Simpan')
            ->pause(2000) // beri waktu untuk redirect selesai
            ->screenshot('create-after-submit')
            ->assertPathBeginsWith('/admin/user'); // cukup pastikan redirect benar
    });
}



    public function test_edit_user_by_id()
    {
        $user = User::where('email', 'mikaadinar@gmail.com')->first(); // User yang akan diedit
        $this->assertNotNull($user, 'User dengan email mikaadinar@gmail.com tidak ditemukan.');

        $admin = User::where('email', 'nurulgeiufwedjwija@gmail.com')->first();
        $this->assertNotNull($admin, 'Admin user tidak ditemukan.');

        $this->browse(function (Browser $browser) use ($admin, $user) {
            $browser->loginAs($admin)
                ->visit("/admin/user/{$user->id}/edit")
                ->pause(1000)
                ->screenshot('edit-before-fill')
                ->type('name', 'User Diedit')
                ->type('email', 'edited.mikaadinar@gmail.com') // Update email
                ->select('status_akun', 'approved') // Sesuaikan dengan name field form jika perlu
                ->select('role', 'orangtua')
                ->screenshot('edit-before-submit')
                ->press('Update')
                ->pause(1500)
                ->screenshot('edit-after-submit')
                ->assertPathIs("/admin/user");
        });
    }
    public function test_delete_user()
    {
        $admin = User::where('email', 'nurulgeiufwedjwija@gmail.com')->first();
        $this->assertNotNull($admin, 'Admin user tidak ditemukan.');

        $user = User::where('email', 'edited.mikaadinar@gmail.com')->first();
        $this->assertNotNull($user, 'User tidak ditemukan');

        $this->browse(function (Browser $browser) use ($admin, $user) {
            $browser->loginAs($admin)
                ->visit('/user')
                ->pause(1000)
                ->waitFor("@dropdown-{$user->id}", 10)
                ->click("@dropdown-{$user->id}")
                ->pause(500)
                ->waitFor("@delete-{$user->id}", 10)
                ->screenshot("delete-before-click")
                ->click("@delete-{$user->id}")
                ->pause(500)
                ->acceptDialog()
                ->pause(1500)
                ->assertDontSee($user->name)
                ->screenshot("delete-after");
        });
    }

}
