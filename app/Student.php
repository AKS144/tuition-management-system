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
        'full_name', 'nric', 'age', 'level', 'mobile_no', 'date_joined', 'status'
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
}
