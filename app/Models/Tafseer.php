<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tafseer extends Model
{
    use HasFactory;

    protected $table = 'tafseer';

     protected $fillable = [
        'ayah_id',
        'tafseer',
    ];

    
    public function ayah()
    {
        return $this->BelongsTo(Ayah::class,'ayah_id','id');
    }

}
