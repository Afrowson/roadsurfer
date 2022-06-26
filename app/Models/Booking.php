<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @method static Builder whereNotBooked(Carbon $fromDate, Carbon $toDate)
 * @method static Builder whereBooked(Carbon $fromDate, Carbon $toDate)
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booked_at',
        'location_id',
        'equipment_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function scopeWhereNotBooked(Builder $query, Carbon $fromDate, Carbon $toDate)
    {
        return $query->where(function (Builder $query) use ($fromDate, $toDate) {
            $query->whereDate('booked_at', '<=', $fromDate->toDateString())
                ->orWhereDate('booked_at', '>=', $toDate->toDateString());
        });
    }

    public function scopeWhereBooked(Builder $query, Carbon $fromDate, Carbon $toDate)
    {
        return $query->where(function (Builder $query) use ($fromDate, $toDate) {
            $query->whereDate('booked_at', '>=', $fromDate->toDateString())
                ->whereDate('booked_at', '<=', $toDate->toDateString());
        });
    }
}
