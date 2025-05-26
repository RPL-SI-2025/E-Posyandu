<?php

namespace Tests\Browser\test_artikel;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Artikel;
use Facebook\WebDriver\WebDriverBy;

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
            'is_show' => true,
            'author' => 'Admin'
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
     * Test Create Article (C)
     */
    public function test_create_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->waitFor('@create-article')
                    ->click('@create-article')
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/create')
                    ->waitFor('#judul')
                    ->type('judul', 'Test Artikel Baru')
                    ->pause(2000); // Wait for CKEditor to initialize

            // Set CKEditor content using JavaScript
            $browser->driver->executeScript("
                if (window.editor) {
                    window.editor.setData('Isi artikel baru untuk testing');
                } else {
                    document.querySelector('.ck-editor__editable').innerHTML = 'Isi artikel baru untuk testing';
                }
            ");

            $browser->waitFor('#is_show')
                    ->check('is_show')
                    ->waitFor('@save-article')
                    ->press('@save-article')
                    ->pause(5000) // Increase pause time for form submission
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Test Artikel Baru');
        });
    }

    /**
     * Test Read Article (R)
     */
    public function test_read_article()
    {
        $this->browse(function (Browser $browser) {
            // Test viewing article list
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->assertSee('Daftar Artikel')
                    ->assertSee($this->artikel->judul)
                    ->assertSee($this->artikel->created_at->format('d-m-Y'))
                    ->assertSee('Tampil');

            // Test viewing single article
            $browser->waitFor('@view-article-' . $this->artikel->id_artikel)
                    ->click('@view-article-' . $this->artikel->id_artikel)
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/' . $this->artikel->id_artikel)
                    ->assertSee($this->artikel->judul)
                    ->assertSee($this->artikel->isi)
                    ->assertSee($this->artikel->author)
                    ->assertSee('Tampil');
        });
    }

    /**
     * Test Update Article (U)
     */
    public function test_update_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->waitFor('@edit-article-' . $this->artikel->id_artikel)
                    ->click('@edit-article-' . $this->artikel->id_artikel)
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/' . $this->artikel->id_artikel . '/edit')
                    ->waitFor('#judul')
                    ->type('judul', 'Artikel Update Test')
                    ->pause(2000); // Wait for CKEditor to initialize

            // Set CKEditor content using JavaScript
            $browser->driver->executeScript("
                if (window.editor) {
                    window.editor.setData('Isi artikel yang diupdate untuk testing');
                } else {
                    document.querySelector('.ck-editor__editable').innerHTML = 'Isi artikel yang diupdate untuk testing';
                }
            ");

            $browser->waitFor('#is_show')
                    ->uncheck('is_show')
                    ->waitFor('@update-article')
                    ->press('@update-article')
                    ->pause(5000) // Increase pause time for form submission
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Artikel Update Test')
                    ->assertSee('Tidak Tampil');
        });
    }

    /**
     * Test Delete Article (D)
     */
    public function test_delete_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->waitFor('@delete-article-' . $this->artikel->id_artikel)
                    ->click('@delete-article-' . $this->artikel->id_artikel)
                    ->assertDialogOpened('Yakin ingin menghapus artikel ini?')
                    ->acceptDialog()
                    ->pause(3000)
                    ->assertDontSee($this->artikel->judul);
        });
    }

    /**
     * Test Complete CRUD Flow
     */
    public function test_complete_crud_flow()
    {
        $this->browse(function (Browser $browser) {
            // Create
            $browser->visit('/admin/artikel')
                    ->pause(2000)
                    ->waitFor('@create-article')
                    ->click('@create-article')
                    ->pause(2000)
                    ->waitFor('#judul')
                    ->type('judul', 'Test CRUD Flow')
                    ->pause(2000); // Wait for CKEditor to initialize

            // Set CKEditor content using JavaScript
            $browser->driver->executeScript("
                if (window.editor) {
                    window.editor.setData('Testing complete CRUD flow');
                } else {
                    document.querySelector('.ck-editor__editable').innerHTML = 'Testing complete CRUD flow';
                }
            ");

            $browser->waitFor('#is_show')
                    ->check('is_show')
                    ->waitFor('@save-article')
                    ->press('@save-article')
                    ->pause(5000) // Increase pause time for form submission
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Test CRUD Flow');

            // Wait for article to be created and get its ID
            $browser->pause(2000); // Give extra time for database to update
            $newArticle = Artikel::where('judul', 'Test CRUD Flow')->first();

            if (!$newArticle) {
                $this->fail('Article was not created successfully');
            }

            $newArticleId = $newArticle->id_artikel;

            // Verify article exists in the list
            $browser->waitFor('@view-article-' . $newArticleId)
                    ->assertSee('Test CRUD Flow');

            // Read
            $browser->click('@view-article-' . $newArticleId)
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/' . $newArticleId)
                    ->assertSee('Test CRUD Flow')
                    ->assertSee('Testing complete CRUD flow');

            // Update
            $browser->visit('/admin/artikel') // Go back to list first
                    ->pause(2000)
                    ->waitFor('@edit-article-' . $newArticleId)
                    ->click('@edit-article-' . $newArticleId)
                    ->pause(2000)
                    ->assertPathIs('/admin/artikel/' . $newArticleId . '/edit')
                    ->waitFor('#judul')
                    ->type('judul', 'Test CRUD Flow Updated')
                    ->pause(2000); // Wait for CKEditor to initialize

            // Set CKEditor content using JavaScript
            $browser->driver->executeScript("
                if (window.editor) {
                    window.editor.setData('Testing complete CRUD flow - Updated');
                } else {
                    document.querySelector('.ck-editor__editable').innerHTML = 'Testing complete CRUD flow - Updated';
                }
            ");

            $browser->waitFor('@update-article')
                    ->press('@update-article')
                    ->pause(5000) // Increase pause time for form submission
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Test CRUD Flow Updated');

            // Delete
            $browser->waitFor('@delete-article-' . $newArticleId)
                    ->click('@delete-article-' . $newArticleId)
                    ->assertDialogOpened('Yakin ingin menghapus artikel ini?')
                    ->acceptDialog()
                    ->pause(3000)
                    ->assertDontSee('Test CRUD Flow Updated');
        });
    }
}
