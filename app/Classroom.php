<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 
        'name', 
        'batch_year',
        'tutor_id', 
    ];

    /**
     * Get the tutor associated with the classroom
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the student associated with the classroom
     */
    public function student(){
        return $this->belongsToMany(Student::class, 'classroom_student');
    }

    /**
     * Get the schedule associated with the classroom
     */
    public function schedule(){
        return $this->belongsToMany(Schedule::class, 'classroom_schedule');
    }
}
