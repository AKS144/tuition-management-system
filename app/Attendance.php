<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'status', 'remarks', 'class_student_id'
    ];

    /**
     * Get the roles associated with the user
     */
    public function classAttendance(){
        return $this->belongsTo(Classroom::class);
    }
}
