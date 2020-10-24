<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 
        'mobile_no', 
        'age', 
        'nric',
        'address', 
        'experience', 
        'date_employed', 
        'status', 
        'is_active',
        'branch_id',
    ];

    /**
     * Get the classroom associated with the tutor
     */
    public function classroom(){
        return $this->hasMany(Classroom::class);
    }

    /**
     * Get the branch associated with the tutor
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
