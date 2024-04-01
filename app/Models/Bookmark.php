<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmark';

     protected $fillable = [
        'firstname',
        'email',
        'surah',
        'ayah',
        'surah_id',
        'ayah_id'
    ];
}
