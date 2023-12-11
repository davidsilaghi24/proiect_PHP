<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'journalist_id',
        'title',
        'content',
    ];

    /**
     * Get the journalist that owns the article.
     */
    public function journalist()
    {
        return $this->belongsTo(Journalist::class);
    }
}
