<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepresentationReservation extends Model
{
    protected $table = 'representation_reservation';

    protected $fillable = [
        'representation_id',
        'reservation_id',
        'price_id',
        'quantity',
    ];

    public function representation(): BelongsTo
    {
        return $this->belongsTo(Representation::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }
}
