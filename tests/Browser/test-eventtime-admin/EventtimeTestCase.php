<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventtimeTestCase extends DuskTestCase
{

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for testing
        $this->admin = User::factory()->create([
            'email' => 'salwa.ockry@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }

    /** @test */
    public function it_can_view_event_time_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.index'))
                    ->assertSee('Daftar Kegiatan')
                    ->assertSee('Tambah Jadwal')
                    ->assertPresent('table.table-bordered')
                    ->assertSee('Belum ada jadwal waktu kegiatan.');
        });
    }

    /** @test */
    public function it_can_create_event_time_with_valid_data()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.create'))
                    ->assertSee('Tambah Jadwal Kegiatan')
                    ->type('tanggal', '2025-06-01')
                    ->type('jam_mulai', '11:00')
                    ->type('jam_selesai', '13:00')
                    ->type('lokasi', 'Posyandu Mawar')
                    ->type('keterangan', 'Vaksinasi Anak')
                    ->press('Simpan Jadwal')
                    ->assertPathIs('/dashboard/admin/event')
                    ->assertSee('Jadwal Kegiatan')
                    ->assertSee('Posyandu Mawar')
                    ->assertSee('Vaksinasi Anak');
        });
    }

    /** @test */
    public function it_fails_to_create_event_time_with_invalid_data()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.create'))
                    ->assertSee('Tambah Jadwal Kegiatan')
                    // Submit form with missing required fields
                    ->press('Simpan Jadwal')
                    ->assertSee('The tanggal field is required.')
                    ->assertSee('The jam_mulai field is required.')
                    ->assertSee('The jam_selesai field is required.')
                    ->assertSee('The lokasi field is required.');
        });
    }

    /** @test */
    public function it_can_edit_event_time()
    {
        // Create an event for testing
        $event = \App\Models\Eventtime::factory()->create([
            'tanggal' => '2025-06-01',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'lokasi' => 'Posyandu Mawar',
            'keterangan' => 'Vaksinasi Anak',
        ]);

        $this->browse(function (Browser $browser) use ($event) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.edit', $event->id))
                    ->assertSee('Update Jadwal Waktu Kegiatan')
                    ->assertInputValue('tanggal', '2025-06-01')
                    ->assertInputValue('jam_mulai', '09:00')
                    ->assertInputValue('jam_selesai', '11:00')
                    ->assertInputValue('lokasi', 'Posyandu Mawar')
                    ->assertInputValue('keterangan', 'Vaksinasi Anak')
                    ->type('lokasi', 'Posyandu Melati')
                    ->type('keterangan', 'Pemeriksaan Kesehatan')
                    ->press('Simpan')
                    ->assertPathIs('/dashboard/admin/event')
                    ->assertSee('Posyandu Melati')
                    ->assertSee('Pemeriksaan Kesehatan');
        });
    }

    /** @test */
    public function it_can_delete_event_time()
    {
        // Create an event for testing
        $event = \App\Models\Eventtime::factory()->create([
            'tanggal' => '2025-06-01',
            'lokasi' => 'Posyandu Mawar',
        ]);

        $this->browse(function (Browser $browser) use ($event) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.index'))
                    ->assertSee('Posyandu Mawar')
                    ->pressAndWaitFor('Delete', ['seconds' => 5])
                    ->acceptDialog()
                    ->assertDontSee('Posyandu Mawar');
        });
    }

    /** @test */
    public function it_can_view_event_time_details()
    {
        // Create an event for testing
        $event = \App\Models\Eventtime::factory()->create([
            'tanggal' => '2025-06-01',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'lokasi' => 'Posyandu Mawar',
            'keterangan' => 'Vaksinasi Anak',
        ]);

        $this->browse(function (Browser $browser) use ($event) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.show', $event->id))
                    ->assertSee('Detail Waktu Kegiatan')
                    ->assertSee(\Carbon\Carbon::parse($event->tanggal)->format('d M Y'))
                    ->assertSee('09:00')
                    ->assertSee('11:00')
                    ->assertSee('Posyandu Mawar')
                    ->assertSee('Vaksinasi Anak')
                    ->assertSee('Kembali');
        });
    }

    /** @test */
    public function it_displays_event_in_calendar()
    {
        // Create an event for testing
        $event = \App\Models\Eventtime::factory()->create([
            'tanggal' => '2025-06-01',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'lokasi' => 'Posyandu Mawar',
            'keterangan' => 'Vaksinasi Anak',
        ]);

        $this->browse(function (Browser $browser) use ($event) {
            $browser->loginAs($this->admin)
                    ->visit(route('dashboard.admin.event.show', $event->id))
                    ->assertSee('Acara: Vaksinasi Anak')
                    ->assertPresent('#calendar')
                    // Limited calendar interaction: Check if calendar div is rendered
                    ->assertScript("document.querySelector('#calendar').innerHTML !== ''");
        });
    }
}