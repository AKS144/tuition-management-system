<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tutor;

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
        'experience', 
        'date_employed', 
        'status', 
        'is_active',
        'branch_id',
    ];

    /**
     * Get the classroom associated with the tutor
     */
    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }

    /**
     * Get the branch associated with the tutor
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the of the tutor address.
     */
    public function addresses()
    {
        return $this->morphMOne(Address::class, 'addressable');
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('tutors.branch_id', $branch_id);
    }
}
