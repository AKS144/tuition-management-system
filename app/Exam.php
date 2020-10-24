<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'start_date', 
        'duration',
        'exam_type_id',
        'subject_level_id',
    ];

    /**
     * Get the exam type associated with the exam
     */
    public function examType(){
        return $this->hasMany(ExamType::class);
    }

    /**
     * Get the subject level associated with the exam type
     */
    public function subjectLevel(){
        return $this->belongsTo(SubjectLevel::class);
    }
    
    /**
     * Get the exam type associated with the exam
     */
    public function examResult(){
        return $this->hasMany(ExamResult::class);
    }
}
