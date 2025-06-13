<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'type',
        'price',
        'startDate',
        'endDate',
    ];

    protected $table = 'prices';

    public $timestamps = false;

    /**
     * Renvoie tous les spectacles pour lesquels ce tarif s'applique
     */
    public function shows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class);
    }
}
