<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function show(): BelongsTo
    {
        return $this->belongsTo(show::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function representationReservations(): HasMany
    {
        return $this->hasMany(RepresentationReservation::class);
    }

}
