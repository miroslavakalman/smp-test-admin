<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_name',
        'phone',
        'booking_date',
        'booking_time',
        'in_club_status',
        'sim_setup',
        'quantity',
        'duration',
        'club_id',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
