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
        'student_id',
        'invoice_id,'
    ];

    /**
     * Get the user associated with the payment
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment method associated with the payment
     */
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the student associated with the payment
     */
    public function student(){
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the student associated with the payment
     */
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->whereHas('user', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%')
                    ->orWhere('contact_name', 'LIKE', '%'.$term.'%')
                    ->orWhere('branch_name', 'LIKE', '%'.$term.'%');
            });
        }
    }

    public function scopePaymentNumber($query, $paymentNumber)
    {
        return $query->where('payments.payment_number', 'LIKE', '%'.$paymentNumber.'%');
    }

    public function scopePaymentMethod($query, $paymentMethodId)
    {
        return $query->where('payments.payment_method_id', $paymentMethodId);
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }

        if ($filters->get('payment_number')) {
            $query->paymentNumber($filters->get('payment_number'));
        }

        if ($filters->get('payment_method_id')) {
            $query->paymentMethod($filters->get('payment_method_id'));
        }

        if ($filters->get('student_id')) {
            $query->whereStudent($filters->get('student_id'));
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'payment_number';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('payments.branch_id', $branch_id);
    }

    public function scopeWhereStudent($query, $student_id)
    {
        $query->where('payments.student_id', $student_id);
    }
}
