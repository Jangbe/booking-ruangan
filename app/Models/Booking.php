<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    public $casts = ['booking_date' => 'date'];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class)->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acceptor()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}
