<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
