<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'langue',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $timestamps = false;


    /**
     * Get the reservations of the user.
     * 
     * @return The reservations of the user.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

     /**
     * Get the roles of the user.
     * 
     * @return The roles  of the user.
     */


    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Logique pour autoriser l'accès à l'admin
        return true; // ou $this->is_admin
    }
  
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);

    }


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists();
    }

    /**
     * Get the user's full name for Filament.
     */
    public function getFilamentName(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }
}
