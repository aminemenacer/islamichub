<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ayah extends Model
{
    use HasFactory;

    protected $table = 'ayah';

     protected $fillable = [
        'surah_id',
        'ayah_id',
        'ayah_text',
        'audio_links'
    ];

    public function surah()
    {
        return $this->BelongsTo(Surah::class,'surah_id','id');
    }

    public function translations()
    {
        return $this->hasMany(Information::class); // Adjust based on your database schema
    }

    public function ayah()
    {
        return $this->BelongsTo(Information::class,'ayah_id','id');
    }

}
