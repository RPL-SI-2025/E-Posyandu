<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       
        'phone',     
        'address',   
        'status_akun', // Added status_akun to fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $attributes = [
        'verifikasi' => 'waiting', // Default value
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Cast to DateTime
            'password' => 'hashed',            // Ensure password is hashed
        ];
    }


    /**
     * Relasi ke tabel table_child (Orangtua memiliki banyak anak).
     */
    public function children()
    {
        return $this->hasMany(Child::class, 'user_id');
    }

    /**
     * Relasi ke tabel table_inspection (Petugas melakukan banyak pemeriksaan).
     */
    public function inspections()
    {
        return $this->hasMany(TableInspection::class, 'user_id');
    }
}
