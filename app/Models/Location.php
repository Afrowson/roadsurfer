<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
