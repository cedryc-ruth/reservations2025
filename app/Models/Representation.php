<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Representation extends Model
{
    protected $fillable = [
        'show_id',
        'schedule',
        'location_id',
    ];

    protected $table = 'representations';
    
    public $timestamps = false;

    public function artistTypes() : BelongsToMany
    {
        return $this->belongsToMany(ArtistType::class);
    }

    public function show(): BelongsToMany
    {
        return $this->belongsToMany(show::class);
    }

    public function location(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    public function representationReservations(): HasMany
    {
        return $this->hasMany(RepresentationReservation::class);
    }

}
