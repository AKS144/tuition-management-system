<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the subject list associated with the level
     */
    public function subject(){
        return $this->belongsToMany(Subject::class, 'subject_levels');
    }
}
