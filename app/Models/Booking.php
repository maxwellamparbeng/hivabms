<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model
{ 
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phoneNumber',
        'bookingDate',
        'researchTopic',
        'discipline',
        'levelOfResearch',
        'problemDescription',
        'service',
        'amountPayed',
        'bookingStatus',
        
        
        // add all other fields
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $primaryKey = 'bookingId';
    public $timestamps = false;
    protected $table = 'bookings';
}
