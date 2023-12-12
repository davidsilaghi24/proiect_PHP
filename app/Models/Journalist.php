<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Journalist extends Model
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
     * Get the user associated with the journalist.
     */
    public function user()
    {
        // Utilizează coloana 'email' din tabela 'journalists' pentru a face legătura cu tabela 'users'.
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Get the articles written by the journalist.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
