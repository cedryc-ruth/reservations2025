<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locality extends Model
{
    protected $fillable = [
        'postal_code',
        'locality',
    ];

    protected $table = 'localities';
    
    protected $primaryKey = 'postal_code';

    public $timestamps = false;

    public function locations() :HasMany
    {
        return $this->hasMany(Location::class);
    }
}
