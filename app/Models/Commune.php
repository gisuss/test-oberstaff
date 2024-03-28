<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Commune extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_reg',
        'description',
        'status',
    ];

    public function customers() : BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function region() : BelongsTo {
        return $this->belongsTo(Region::class, 'id_reg');
    }
}
