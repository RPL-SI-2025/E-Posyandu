<?php

namespace Tests\Browser\test_artikel;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ArtikelTestCase extends DuskTestCase
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
                    ->type('email', 'dava.ihza18@gmail.com')
                    ->type('password', 'dava.ihza18')
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/admin/dashboard');
        });
    }

    /**
     * Test creating a new article with valid data
     */
    public function test_create_article_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@create-article')
                    ->type('judul', 'Test Artikel')
                    ->type('isi', 'Isi artikel')
                    ->press('@save-article')
                    ->assertSee('Artikel berhasil disimpan');
        });
    }

    /**
     * Test viewing article list
     */
    public function test_view_article_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->assertSee('Daftar Artikel')
                    ->assertPresent('table')
                    ->assertPresent('@create-article');
        });
    }

    /**
     * Test viewing single article
     */
    public function test_view_single_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->click('@view-article', '1')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/1')
                    ->assertPresent('@edit-article')
                    ->assertPresent('@delete-article');
        });
    }

    /**
     * Test editing article
     */
    public function test_edit_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@edit-article-1')
                    ->type('judul', 'Artikel Update')
                    ->press('@update-article')
                    ->assertSee('Artikel berhasil diperbarui');
        });
    }

    /**
     * Test deleting article
     */
    public function test_delete_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@delete-article-1')
                    ->acceptDialog()
                    ->assertSee('Artikel berhasil dihapus');
        });
    }

    /**
     * Test article visibility toggle
     */
    public function test_toggle_article_visibility()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->click('@edit-article', '1')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/1/edit')
                    ->uncheck('is_show')
                    ->press('Update')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Tidak Tampil')
                    ->click('@edit-article', '1')
                    ->pause(2000)
                    ->check('is_show')
                    ->press('Update')
                    ->pause(2000)
                    ->assertSee('Tampil');
        });
    }
}
