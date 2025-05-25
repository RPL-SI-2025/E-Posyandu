<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_inspection';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_child_id',
        'user_id',
        'tanggal_pemeriksaan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'catatan',
        'eventtime_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel Child (Anak yang diperiksa).
     */
    public function child()
    {
        return $this->belongsTo(Child::class, 'table_child_id');
    }

    /**
     * Relasi ke tabel User (Petugas yang memeriksa).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel Eventtime (Jadwal pemeriksaan).
     */
    public function eventtime()
    {
        return $this->belongsTo(Eventtime::class, 'eventtime_id');
    }
}
