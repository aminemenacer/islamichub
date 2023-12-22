<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $table = 'surah';

    protected $fillable = [
        'juz_id',
        'name_en',
        'name_ar'
    ];

    public function ayat()
    {
        return $this->hasMany(Ayah::class);
    }

    public function juz()
    {
        return $this->BelongsTo(Juz::class,'juz_id','id');
    }
}
