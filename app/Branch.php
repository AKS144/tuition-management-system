<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'city'
    ];

    /**
     * Get the user associated with the branch
     */
    public function user(){
        return $this->belongsToMany(User::class, 'branch_user');
    }

    /**
     * Get the venue associated with the branch
     */
    public function venue(){
        return $this->belongsToMany(Venue::class, 'branch_venues');
    }

    /**
     * Get the student associated with the branch
     */
    public function student(){
        return $this->hasMany(Student::class);
    }

    /**
     * Get the tutor associated with the branch
     */
    public function tutor(){
        return $this->hasMany(Tutor::class);
    }
}
