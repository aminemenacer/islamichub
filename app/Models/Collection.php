<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    
}