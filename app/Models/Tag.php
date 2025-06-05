<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag'];

    /**
     * Relation many-to-many avec Show
     */
    public function shows()
    {
        return $this->belongsToMany(Show::class);
    }
}
