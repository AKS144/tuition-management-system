<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time', 
        'end_time'
    ];

    /**
     * Get the DayTimeSlot associated with the timeslot
     */
    public function dayTimeSlot(){
        return $this->belongsTo(DayTimeSlot::class);
    }
}
