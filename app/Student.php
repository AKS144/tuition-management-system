<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Branch;
use Carbon\Carbon;
use App\BranchSetting;

class Student extends Model
{
    protected $table = 'students';

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

    protected $appends = [
        'formattedJoinedAt',
    ];

    public function getFormattedJoinedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->date_joined)->format($dateFormat);
    }

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
        return $this->belongsToMany(Parents::class, 'parent_student');
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

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where(function ($query) use ($term) {
                $query->where('full_name', 'LIKE', '%'.$term.'%');
            });
        }
    }

    public function scopeWhereFullName($query, $full_name)
    {
        return $query->where('full_name', 'LIKE', '%'.$full_name.'%');
    }

    public function scopeWhereNric($query, $nric)
    {
        return $query->where('nric', 'LIKE', '%'.$nric.'%');
    }

    public function scopeWhereMobileNo($query, $mobileNo)
    {
        return $query->where('mobile_no', 'LIKE', '%'.$mobileNo.'%');
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }

        if ($filters->get('full_name')) {
            $query->whereFullName($filters->get('full_name'));
        }

        if ($filters->get('nric')) {
            $query->whereNric($filters->get('nric'));
        }

        if ($filters->get('mobile_no')) {
            $query->whereMobileNo($filters->get('mobile_no'));
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'full_name';
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
