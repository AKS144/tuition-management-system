<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectLevel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level_id', 
        'subject_id',
    ];

    /**
     * Get the material associated with the subject level
     */
    public function material(){
        return $this->hasMany(Material::class);
    }

    /**
     * Get the package associated with the subject level
     */
    public function package(){
        return $this->belongsToMany(Package::class, 'subject_level_package');
    }

    /**
     * Get the exam associated with the subject level
     */
    public function examType(){
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the level associated with the subject level
     */
    public function level(){
        return $this->hasMany(Level::class);
    }

    /**
     * Get the subject type associated with the subject level
     */
    public function subject(){
        return $this->hasMany(Subject::class);
    }
}
