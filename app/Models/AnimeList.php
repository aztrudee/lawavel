<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeList extends Model
{
    protected $fillable = ['user_id', 'title', 'genre', 'status', 'episodes', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
