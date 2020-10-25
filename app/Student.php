<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 
        'nric', 
        'age', 
        'level', 
        'mobile_no', 
        'date_joined', 
        'status'
    ];

    /**
     * Get the branch associated with the student
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the payment associated with the student
     */
    public function payment(){
        return $this->belongsToMany(Payment::class, 'student_payment');
    }

    /**
     * Get the package associated with the student
     */
    public function package(){
        return $this->belongsToMany(Package::class, 'student_package');
    }

    /**
     * Get the student associated with the parent
     */
    public function parents(){
        return $this->belongsToMany(Parent::class, 'parent_student');
    }

    /**
     * Get the exam type associated with the student
     */
    public function examResult(){
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Get the classroom associated with the student
     */
    public function classroom(){
        return $this->belongsToMany(Classroom::class, 'classroom_student');
    }
}
