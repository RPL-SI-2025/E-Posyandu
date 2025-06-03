<?php

namespace Tests\Browser\test_artikel_orangtua;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Artikel;
use App\Models\User;
use Facebook\WebDriver\WebDriverBy;

class ArtikelTest extends DuskTestCase
{
    protected $artikel;

    public function setUp(): void
    {
        parent::setUp();
        // Create a test article for testing read operations by orangtua
        $this->artikel = Artikel::create([
            'judul' => 'Test Artikel Orangtua',
            'isi' => 'Isi artikel untuk testing orangtua',
            'is_show' => true,
            'author' => 'Admin'
        ]);
    }

    public function tearDown(): void
    {
        // Clean up test data
        Artikel::where('judul', 'Test Artikel Orangtua')->delete();
        Artikel::where('judul', 'Test Artikel Baru')->delete(); // Clean up potential leftovers
        Artikel::where('judul', 'Artikel Update Test')->delete(); // Clean up potential leftovers
        Artikel::where('judul', 'Test CRUD Flow')->delete(); // Clean up potential leftovers
        Artikel::where('judul', 'Test CRUD Flow Updated')->delete(); // Clean up potential leftovers
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
     * Test viewing news article list as orangtua.
     * @depends test_login_orangtua
     */
    public function test_view_article_list_orangtua()
    {
        $this->browse(function (Browser $browser) {
             $browser->loginAs(User::where('email', 'orangtua@gmail.com')->first())
                     ->visit('/orangtua/berita')
                     ->pause(1000) // Adjust pause if needed
                     ->assertSee('Artikel Terbaru') // Assert main page title
                     ->assertSee('Artikel Terbaru') // Assert section header
                     ->assertSee($this->artikel->judul) // Assert test article title is visible
                     ->assertSee('Baca Selengkapnya'); // Assert Baca Selengkapnya button is visible
        });
    }

    /**
     * Test viewing a single news article as orangtua and returning to the list.
     * @depends test_view_article_list_orangtua
     */
    public function test_view_single_article_and_return_orangtua()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email', 'orangtua@gmail.com')->first())
                    ->visit('/orangtua/berita')
                    ->pause(1000) // Adjust pause if needed to ensure articles load
                    ->assertSee($this->artikel->judul) // Ensure the article is on the list page
                    ->clickLink('Baca Selengkapnya') // Click the button for the test article
                    ->pause(1000) // Adjust pause if needed for detail page load
                    ->assertPathIs('/orangtua/berita/' . $this->artikel->id_artikel) // Assert correct detail page URL
                    ->assertSee($this->artikel->judul) // Assert title on detail page
                    ->assertSee($this->artikel->isi) // Assert full content on detail page
                    ->assertSee('Kembali ke Berita') // Assert the back button is visible
                    ->clickLink('Kembali ke Berita') // Click the back button
                    ->pause(1000) // Adjust pause if needed for list page load
                    ->assertPathIs('/orangtua/berita') // Assert return to the news list page
                    ->assertSee('Artikel Terbaru'); // Assert an element on the list page to confirm return (main title)
        });
    }

    // Removed Admin CRUD Tests
}
