<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'show_id',
        'review',
        'stars',
        'validated',
        'created_at',
        'updated_at',
                        ];
    
    protected $table = ['reviews'];

    public $timestamps = false;
}
