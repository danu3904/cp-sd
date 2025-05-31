<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationChartImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'title',
        'description',
    ];

    protected $table = 'organization_chart_images'; // Nama tabel secara eksplisit (opsional tapi bagus)
}