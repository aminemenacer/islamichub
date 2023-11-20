<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    use HasFactory;

    protected $table = 'correction';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'spelling_mistakes',
        'incomplete_text',
        'translation_error',
        'added_notes',
        'reference_error',
        'narrator',
        'hadith_english',
        'hadith_arabic',
        'created_at',
       
    ];
}
