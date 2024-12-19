<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $appends = ['available'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class)->withPivot('quantity');
    }

    public function getAvailableAttribute()
    {
        return $this->quantity - $this->bookings->where('status', 'accepted')->sum('pivot.quantity');
    }
}
