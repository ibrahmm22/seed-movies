<?php

namespace Ibrahim\Movie\Models;

use Ibrahim\Movie\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use Sortable;
    protected $table = 'movies';

    protected $fillable = [
        'movie_id',
        'popularity',
        'vote_count',
        'video',
        'poster_path',
        'adult',
        'backdrop_path',
        'original_language',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category', 'movie_id', 'category_id', 'movie_id', 'movie_category_id');
    }
}
