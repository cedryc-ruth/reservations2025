<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $table = 'reservations';

    public $timestamps = true;
    const CREATED_AT = 'booking_date';

    /**
     * Get the user of the reservation.
     * 
     * @return The user of the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function representationReservations()
    {
        return $this->hasMany(RepresentationReservation::class);
    }

    public function representations()
    {
        return $this->hasManyThrough(Representation::class, RepresentationReservation::class, 'reservation_id', 'id', 'id', 'representation_id');
    }
}
