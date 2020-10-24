<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the DayTimeSlot associated with the day
     */
    public function dayTimeSlot(){
        return $this->belongsTo(DayTimeSlot::class);
    }
}
