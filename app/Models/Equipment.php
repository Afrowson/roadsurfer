<?php

namespace App\Models;

use App\Enums\EquipmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @method Builder whereNotBooked(Carbon $day)
 * @method Builder whereBooked(Carbon $day)
 * @property mixed $location_id
 */
class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'type',
        'value_one',
        'value_two',
    ];

    protected $casts = [
        'type' => EquipmentType::class,
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeWhereAvailableAt(Builder $query, Carbon $date)
    {
        return $query->whereDoesntHave('bookings', function ($query) use ($date) {
            $query->where('booked_at', $date);
        });
    }
    public function scopeWhereNotAvailableAt(Builder $query, Carbon $date)
    {
        return $query->whereHas('bookings', function ($query) use ($date) {
            $query->where('booked_at', $date);
        });
    }
}
