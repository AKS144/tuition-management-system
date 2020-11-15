<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Branch;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 
        'nric', 
        'age', 
        'level', 
        'mobile_no', 
        'date_joined', 
        'status',
        'branch_id',
    ];

    /**
     * Get the branch associated with the student
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the package associated with the student
     */
    public function package(){
        return $this->belongsToMany(Package::class, 'student_package');
    }

    /**
     * Get the student associated with the parent
     */
    public function parents(){
        return $this->belongsToMany(Parent::class, 'parent_student');
    }

    /**
     * Get the exam type associated with the student
     */
    public function examResult(){
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Get the classroom associated with the student
     */
    public function classroom(){
        return $this->belongsToMany(Classroom::class, 'classroom_student');
    }

    /**
     * Get the invoices associated with the student
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the payments associated with the student
     */
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('students.branch_id', $branch_id);
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        // if ($filters->get('search')) {
        //     $query->whereSearch($filters->get('search'));
        // }

        // if ($filters->get('contact_name')) {
        //     $query->whereContactName($filters->get('contact_name'));
        // }

        // if ($filters->get('display_name')) {
        //     $query->whereDisplayName($filters->get('display_name'));
        // }

        // if ($filters->get('phone')) {
        //     $query->wherePhone($filters->get('phone'));
        // }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'name';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class)->where('type', Address::BILLING_TYPE);
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class)->where('type', Address::SHIPPING_TYPE);
    }
}
