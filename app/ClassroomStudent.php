<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassroomStudent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'classroom_id', 
        'student_id',
        'frequency',
        'is_recurring',
    ];

    /**
     * Get the attendance associated with the classroom student
     */
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
