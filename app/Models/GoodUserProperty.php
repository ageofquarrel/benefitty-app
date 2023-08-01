<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\PropertyType;
use App\Models\Good;
use App\Models\User;

class GoodUserProperty extends Model
{
    use HasFactory;

    public const RENT_HOURS = [4, 8, 12, 24];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'good_id',
        'property_type_id',
        'code',
        'rent_hours'
    ];

    public function propertyType(): HasOne
    {
        return $this->hasOne(PropertyType::class, 'id', 'property_type_id');
    }

    public function good(): HasOne
    {
        return $this->hasOne(Good::class, 'id', 'good_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
