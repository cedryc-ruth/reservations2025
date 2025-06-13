<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RepresentationReservation extends Model
{
    protected $table = 'representation_reservation';
    public $timestamps = false;

    protected $fillable = [
        'representation_id',
        'reservation_id',
        'price_id',
        'quantity',
    ];

    public function representation(): BelongsToMany
    {
        return $this->belongsToMany(Representation::class);
    }

    public function reservation(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function price(): BelongsToMany
    {
        return $this->belongsToMany(Price::class);
    }
}