<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Show extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'poster_url',
        'duration',
        'created_in',
        'location_id',
        'bookable',
        'price',
        'description',
    ];

    protected $table = 'shows';
    
    public $timestamps = false;

    public function artistTypes() : BelongsToMany
    {
        return $this->belongsToMany(ArtistType::class);
    }

    /**
     * Relation many-to-many avec Tag
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class);
    }
}
