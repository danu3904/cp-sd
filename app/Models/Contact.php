<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'contact';
    protected $guarded = ['id'];
}
