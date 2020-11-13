<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 
        'mobile_no',
        'nric',
    ];

    /**
     * Get the student associated with the parent
     */
    public function students(){
        return $this->belongsToMany(Student::class, 'parent_student');
    }

    /**
     * Get the of the parent address.
     */
    public function addresses()
    {
        return $this->morphMOne(Address::class, 'addressable');
    }
}
