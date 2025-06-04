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
}
