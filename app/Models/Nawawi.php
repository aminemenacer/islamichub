<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nawawi extends Model
{
    use HasFactory;

    protected $table = 'nawawi';


    protected $fillable = [
        'arabic',
        'narrator',
        'text',
        'reference',
              
    ];
}
