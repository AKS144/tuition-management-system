<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mark', 
        'total_mark', 
        'status', 
        'remarks', 
        'grade' 
    ];

    /**
     * Get the exam associated with the exam type
     */
    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the student associated with the exam type
     */
    public function student(){
        return $this->belongsTo(Student::class);
    }
}
