<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventtime extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_eventtime';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
    ];
}
