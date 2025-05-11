<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_child';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
    ];

    /**
     * Relasi ke tabel User (Orangtua).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel table_inspection (Pemeriksaan anak).
     */
    public function inspections()
    {
        return $this->hasMany(TableInspection::class, 'table_child_id');
    }
}
