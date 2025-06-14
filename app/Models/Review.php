<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $table = 'reviews';

    public $timestamps = true;


    public function show() :BelongsTo
    {
        return $this->belongsTo(Show::class);
    }


    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
