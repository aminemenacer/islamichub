<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapter';


    protected $fillable = [
        'chapter_id', 
        'chapter_name',
              
    ];

    public function imam()
    {
        return $this->hasMany(Chapter::class, 'imam_id', 'id');
    }

    public function chapter()
    {
        return $this->BelongsTo(Ahadith::class,'chapter_id','id');
    }
}
