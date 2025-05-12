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
} 