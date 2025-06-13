<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function artistTypes() : BelongsToMany
    {
        return $this->belongsToMany(ArtistType::class);
    }

    /**
     * Renvoie le lieu de création du spectacle
     */
    public function location(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    /**
     * Renvoie tous les tarifs d'un spectacle
     */
    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(Price::class);
    }

    public function representations() :HasMany
    {
        return $this->hasMany(Representation::class);
    }
  
}