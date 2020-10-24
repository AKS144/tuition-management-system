<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchVenue extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 
        'venue_id',
    ];

    /**
     * Get the schedule associated with the branch venue
     */
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
