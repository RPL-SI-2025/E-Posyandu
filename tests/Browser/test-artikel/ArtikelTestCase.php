<?php

namespace Tests\Browser\test_artikel;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Artikel;

class ArtikelTestCase extends DuskTestCase
{
    protected $artikel;

    public function setUp(): void
    {
        parent::setUp();
        // Create a test article for testing edit/delete operations
        $this->artikel = Artikel::create([
            'judul' => 'Test Artikel Awal',
            'isi' => 'Isi artikel awal untuk testing',
            'is_show' => true
        ]);
    }

    public function tearDown(): void
    {
        // Clean up test data
        Artikel::where('judul', 'like', 'Test%')->delete();
        parent::tearDown();
    }

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
                    ->type('judul', 'Test Artikel Baru')
                    ->type('isi', 'Isi artikel baru untuk testing')
                    ->check('is_show')
                    ->press('@save-article')
                    ->pause(2000)
                    ->assertSee('Artikel berhasil disimpan')
                    ->assertSee('Test Artikel Baru');
        });
    }

    /**
     * Test creating article with invalid data
     */
    public function test_create_article_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@create-article')
                    ->press('@save-article')
                    ->pause(2000)
                    ->assertSee('Judul harus diisi')
                    ->assertSee('Isi artikel harus diisi')
                    ->type('judul', '')
                    ->type('isi', '')
                    ->press('@save-article')
                    ->pause(2000)
                    ->assertSee('Judul harus diisi')
                    ->assertSee('Isi artikel harus diisi');
        });
    }

    /**
     * Test creating article with minimum length validation
     */
    public function test_create_article_minimum_length()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@create-article')
                    ->type('judul', 'Te')
                    ->type('isi', 'Is')
                    ->press('@save-article')
                    ->pause(2000)
                    ->assertSee('Judul minimal 3 karakter')
                    ->assertSee('Isi artikel minimal 10 karakter');
        });
    }

    /**
     * Test viewing article list with pagination
     */
    public function test_view_article_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->assertSee('Daftar Artikel')
                    ->assertPresent('table')
                    ->assertPresent('@create-article')
                    ->assertPresent('@pagination')
                    ->assertSee($this->artikel->judul);
        });
    }

    /**
     * Test viewing single article with all details
     */
    public function test_view_single_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->click('@view-article-1')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/1')
                    ->assertSee($this->artikel->judul)
                    ->assertSee($this->artikel->isi)
                    ->assertPresent('@edit-article')
                    ->assertPresent('@delete-article')
                    ->assertPresent('@back-to-list');
        });
    }

    /**
     * Test editing article with valid data
     */
    public function test_edit_article_valid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@edit-article-1')
                    ->type('judul', 'Artikel Update Test')
                    ->type('isi', 'Isi artikel yang diupdate untuk testing')
                    ->check('is_show')
                    ->press('@update-article')
                    ->pause(2000)
                    ->assertSee('Artikel berhasil diperbarui')
                    ->assertSee('Artikel Update Test');
        });
    }

    /**
     * Test editing article with invalid data
     */
    public function test_edit_article_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@edit-article-1')
                    ->type('judul', '')
                    ->type('isi', '')
                    ->press('@update-article')
                    ->pause(2000)
                    ->assertSee('Judul harus diisi')
                    ->assertSee('Isi artikel harus diisi');
        });
    }

    /**
     * Test deleting article with confirmation
     */
    public function test_delete_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@delete-article-1')
                    ->assertDialogOpened('Apakah Anda yakin ingin menghapus artikel ini?')
                    ->acceptDialog()
                    ->pause(2000)
                    ->assertSee('Artikel berhasil dihapus')
                    ->assertDontSee($this->artikel->judul);
        });
    }

    /**
     * Test canceling article deletion
     */
    public function test_cancel_delete_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->click('@delete-article-1')
                    ->assertDialogOpened('Apakah Anda yakin ingin menghapus artikel ini?')
                    ->dismissDialog()
                    ->pause(2000)
                    ->assertSee($this->artikel->judul);
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
                    ->click('@edit-article-1')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/1/edit')
                    ->assertChecked('is_show')
                    ->uncheck('is_show')
                    ->press('Update')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Tidak Tampil')
                    ->click('@edit-article-1')
                    ->pause(2000)
                    ->assertNotChecked('is_show')
                    ->check('is_show')
                    ->press('Update')
                    ->pause(2000)
                    ->assertSee('Tampil');
        });
    }

    /**
     * Test article search functionality
     */
    public function test_search_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->type('@search-input', 'Test Artikel Awal')
                    ->press('@search-button')
                    ->pause(2000)
                    ->assertSee('Test Artikel Awal')
                    ->type('@search-input', 'Artikel Tidak Ada')
                    ->press('@search-button')
                    ->pause(2000)
                    ->assertDontSee('Test Artikel Awal')
                    ->assertSee('Tidak ada artikel yang ditemukan');
        });
    }
}
