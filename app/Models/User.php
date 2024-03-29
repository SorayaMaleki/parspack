<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
      = [
        'name',
        'email',
        'password',
      ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
      = [
        'password',
        'remember_token',
      ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts
      = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
      ];

    /**
     * Set the hashed password attribute.
     *
     * @return \Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
          set: fn(string $value) => bcrypt($value),
        );
    }
    /**
     * Define the relationship between the Comment model and this model.
     *
     * @return HasMany
     */
    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
