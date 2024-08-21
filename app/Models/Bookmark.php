<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'title', 'url', 'surah_name', 'ayah_num', 
        'ayah_verse_ar', 'ayah_verse_en', 'folder_id', 'user_id'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

