<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    use HasFactory;

    protected $table = 'correction';


    protected $fillable = [
        'mistake_type',
        'name',
        'email',
        'added_notes',
        'created_at',
        'hadith_num'
    ];
}
