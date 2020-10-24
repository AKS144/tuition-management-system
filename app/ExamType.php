<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Get the exam associated with the exam type
     */
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
