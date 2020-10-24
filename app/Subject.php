<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];

    /**
     * Get the level list associated with the subject
     */
    public function level(){
        return $this->belongsToMany(Level::class, 'subject_levels');
    }

    /**
     * Get the subject level associated with the subject
     */
    public function subjectLevel(){
        return $this->belongsTo(SubjectLevel::class);
    }
}
