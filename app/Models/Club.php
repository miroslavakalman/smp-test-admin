<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pc_count', 'opening_time', 'closing_time'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
