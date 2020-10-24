<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day_time_slot_id',
        'branch_venue_id',
    ];

    /**
     * Get the branchVenue associated with the schedule
     */
    public function branchVenue(){
        return $this->belongsTo(BranchVenue::class);
    }

    /**
     * Get the DayTimeSlot associated with the schedule
     */
    public function DayTimeSlot(){
        return $this->belongsTo(DayTimeSlot::class);
    }

    /**
     * Get the classroom associated with the schedule
     */
    public function classroom(){
        return $this->belongsToMany(Classroom::class, 'classroom_schedule');
    }
}
