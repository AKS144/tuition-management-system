<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'level'
    ];

    /**
     * Get the subject level associated with the package
     */
    public function subjectLevel(){
        return $this->belongsToMany(SubjectLevel::class, 'subject_level_package');
    }

    /**
     * Get the student associated with the package
     */
    public function student(){
        return $this->belongsToMany(Student::class, 'student_package');
    }
}
