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
        'location_id',
        'bookable',
        'price',
    ];

    protected $table = 'shows';
    
    public $timestamps = false;

    public function artistTypes() : BelongsToMany
    {
        return $this->belongsToMany(ArtistType::class);
    }

}
