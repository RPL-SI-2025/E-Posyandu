<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;

    protected $table = 'table_child';
    protected $fillable = [
        'user_id',
        'nama_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class, 'table_child_id');
    }

    public function latestInspection()
    {
        return $this->hasOne(Inspection::class, 'table_child_id')->latest('tanggal_pemeriksaan');
    }
} 