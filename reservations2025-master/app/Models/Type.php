<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    protected $fillable = [
        'type',
    ];

    protected $table = 'types';
    
    public $timestamps = false;

    public function artists() :BelongsToMany
    {
        return $this->belongsToMany(Artist::class);
    }
}
