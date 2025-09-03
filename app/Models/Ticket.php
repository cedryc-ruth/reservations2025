<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'representation_id',
        'price_id',
        'quantity',
        'total_price',
        'status', // 'pending', 'paid', 'cancelled', 'used'
        'payment_method',
        'payment_reference',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function representation(): BelongsTo
    {
        return $this->belongsTo(Representation::class);
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }

    public function show()
    {
        return $this->representation->show;
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isUsed(): bool
    {
        return $this->status === 'used';
    }
}
