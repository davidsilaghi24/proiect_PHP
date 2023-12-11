<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Journalist extends Model // Schimbă din Authenticatable în Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'biography',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user that owns the journalist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the articles for the journalist.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
