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
        'name', 'city', 'logo', 'unique_hash'
    ];

    /**
     * Get the user associated with the branch
     */
    public function users(){
        return $this->hasMany(User::class);
    }

    /**
     * Get the venue associated with the branch
     */
    public function venues(){
        return $this->belongsToMany(Venue::class, 'branch_venues');
    }

    /**
     * Get the student associated with the branch
     */
    public function students(){
        return $this->hasMany(Student::class);
    }

    /**
     * Get the tutor associated with the branch
     */
    public function tutors(){
        return $this->hasMany(Tutor::class);
    }

    /**
     * Get the expense category associated with the branch
     */
    public function expenseCategorys(){
        return $this->hasMany(ExpenseCategory::class);
    }

    /**
     * Get the tax type associated with the branch
     */
    public function taxTypes(){
        return $this->hasMany(TaxType::class);
    }

    /**
     * Get the item associated with the branch
     */
    public function items(){
        return $this->hasMany(Item::class);
    }

    /**
     * Get the invoice associated with the branch
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the expense associated with the branch
     */
    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the paymentMethod associated with the branch
     */
    public function paymentMethods(){
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Get the tax associated with the branch
     */
    public function taxes(){
        return $this->hasMany(Tax::class);
    }

    /**
     * Get the classroom associated with the branch
     */
    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }

    
    /**
     * Get the of the branch address.
     */
    public function addresses()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
