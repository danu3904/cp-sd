<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description', // Tambahkan ini
        'content',     // Sertakan jika kamu masih menggunakan kolom content
        'image',
    ];
}
