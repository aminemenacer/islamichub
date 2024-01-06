<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = 'information';

    protected $fillable = [
        'tafseer',
        'translation',
        'transliteration',
        'information',
        'images',
        'audio',
        'ayah_id'
    ];

    // RELATIONSHIPS

    public function ayah()
    {
        return $this->BelongsTo(Ayah::class, 'ayah_id', 'id');
    }

    
}
