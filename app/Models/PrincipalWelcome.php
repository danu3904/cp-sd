<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrincipalWelcome extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'principal_welcomes'; // Nama tabel di database

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', // Judul kata sambutan (misalnya "Kata Sambutan Kepala Sekolah")
        'headmaster_name', // Nama Kepala Sekolah
        'content', // Isi teks kata sambutan
        'is_active', // Untuk menandai mana yang aktif jika ada beberapa versi
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
