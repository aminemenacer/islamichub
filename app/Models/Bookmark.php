<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id', 'surah_name', 'ayah_num', 'ayah_verse_ar', 'ayah_verse_en', "ayah_text", "ayah_notes"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



