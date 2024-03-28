<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_com',
        'id_reg',
        'name',
        'last_name',
        'email',
        'dni',
        'address',
        'date_reg',
        'status',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name'       => $name,
            'token'      => hash('SHA256', $plainTextToken = Str::random(250)),
            'abilities'  => $abilities,
            'expires_at' => Carbon::now()->addDays(1), //token lifetime
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function commune() : BelongsTo {
        return $this->belongsTo(Commune::class, 'id_com');
    }
    
    public function region() : BelongsTo {
        return $this->belongsTo(Region::class, 'id_reg');
    }

    public function scopeSearch(Builder $query, string $search) : Builder {
        return $query->where('email', 'like', "%{$search}%")
            ->orWhere('dni', 'like', "%{$search}%")
            ->where('status', 'A');
    }
}
