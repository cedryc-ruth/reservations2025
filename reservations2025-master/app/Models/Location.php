<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    protected $fillable = [
        'slug',
        'designation',
        'address',
        'locality_postal_code',
        'website',
        'phone',
    ];

    protected $table = 'locations';
    
    public $timestamps = false;

    public function locality() :BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    /**
     * Renvoie les spectacles créé dans ce lieu
     */
    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
