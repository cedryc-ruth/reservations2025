<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    protected $table = 'artists';
    
    public $timestamps = false;

    public function types() :BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    /**
     * Get the shows where this artist performs
     */
    public function shows()
    {
        return $this->belongsToMany(Show::class, 'artist_type_show', 'artist_type_id', 'show_id')
            ->join('artist_type', 'artist_type_show.artist_type_id', '=', 'artist_type.id')
            ->where('artist_type.artist_id', $this->id)
            ->select('shows.*')
            ->distinct();
    }

    /**
     * Alternative method using query builder
     */
    public function getShowsAttribute()
    {
        return Show::join('artist_type_show', 'shows.id', '=', 'artist_type_show.show_id')
            ->join('artist_type', 'artist_type_show.artist_type_id', '=', 'artist_type.id')
            ->where('artist_type.artist_id', $this->id)
            ->select('shows.*')
            ->distinct()
            ->get();
    }
}
