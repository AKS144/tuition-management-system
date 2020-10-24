<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayTimeSlot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_slot_id', 
        'day_id'
    ];

    /**
     * Get the day associated with the DayTimeSlot
     */
    public function timeslot(){
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * Get the day associated with the DayTimeSlot
     */
    public function day(){
        return $this->hasMany(Day::class);
    }

    /**
     * Get the schedule associated with the DayTimeSlot
     */
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
