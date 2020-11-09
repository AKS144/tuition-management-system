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
        'payment_number',
        'title', 
        'amount', 
        'notes',
        'unique_hash', 
        'payment_method_id',
        'payment_date', 
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
    public function students(){
        return $this->belongsToMany(Student::class, 'student_payment');
    }
}
