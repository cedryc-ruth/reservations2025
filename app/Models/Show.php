<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Collection;

class Show extends Model implements Feedable
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'poster_url',
        'duration',
        'created_in',
        'location_id',
        'bookable',
    ];

    protected $table = 'shows';
    
    public $timestamps = false;

    public function artistTypes() : BelongsTo
    {
        return $this->belongsTo(ArtistType::class);
    }

    /**
     * Renvoie le lieu de création du spectacle
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Renvoie tous les tarifs d'un spectacle
     */
    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(Price::class, 'price_show');
    }

    public function representations() :HasMany
    {
        return $this->hasMany(Representation::class);
    }
  

    public function reviews() :HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => route('shows.show', $this->id),
            'title' => $this->title,
            'summary' => $this->description,
            'updated' => now(),
            'link' => url("/shows/{$this->slug}"),
            'authorName' => 'Mon Billet',
        ]);
    }

    public static function getFeedItems(): Collection
    {
        return self::orderByDesc('created_in')->take(10)->get();
    }
}
