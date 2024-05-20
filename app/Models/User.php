<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'email',
        'user_type',
        'status',
        'subscribe',
        'google_id',
        'fb_id'
       
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function adminlte_profile_url()
    {
       
        return '/adminlte/profile/' . $this->id;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
