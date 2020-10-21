<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'batch_year', 
    ];

    /**
     * Get the tutor associated with the classroom
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class);
    }
}
