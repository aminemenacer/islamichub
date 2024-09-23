<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    public function ayah()
    {
        return $this->belongsTo(Ayah::class);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
