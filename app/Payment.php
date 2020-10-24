<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'amount', 
        'status', 
        'description', 
        'date_pay', 
        'user_id',
    ];

    /**
     * Get the user associated with the payment
     */
    public function users(){
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student associated with the payment
     */
    public function student(){
        return $this->belongsToMany(Student::class, 'student_payment');
    }
}
