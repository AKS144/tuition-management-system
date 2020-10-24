<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 
        'filetype', 
        'path', 
        'filesize', 
        'subject_level_id',
    ];

    /**
     * Get the subject level associated with the material
     */
    public function subjectLevel(){
        return $this->belongsTo(SubjectLevel::class);
    }
}
