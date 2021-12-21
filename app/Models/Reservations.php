<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_date',
        'room_type',
        'bed_type',
        'room_number',
        'check_in',
        'check_out',
        'bill'
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at']))
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at']))
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
    }
}
