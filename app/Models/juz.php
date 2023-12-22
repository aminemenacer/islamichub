<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class juz extends Model
{
    use HasFactory;

    protected $table = 'juz';

    protected $fillable = [
        'juz_number',
        'name_ar'
    ];

    public function surat()
    {
        return $this->hasMany(Surah::class);
    }

    
}
