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
        'quantity',
        'duration'
    ];
}
