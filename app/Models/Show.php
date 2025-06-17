<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Show extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'poster_url',
        'duration',
        'created_in',
        'location_id',
        'bookable',
    ];

    protected $table = 'shows';
    
    public $timestamps = false;

    public function artistTypes() : BelongsTo
    {
        return $this->belongsTo(ArtistType::class);
    }

    /**
     * Renvoie le lieu de création du spectacle
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Renvoie tous les tarifs d'un spectacle
     */
    public function prices(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }

    public function representations() :HasMany
    {
        return $this->hasMany(Representation::class);
    }
  

    public function reviews() :HasMany
    {
        return $this->hasMany(Review::class);
    }
}
