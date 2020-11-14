<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Payment extends Model
{
    const PAYMENT_MODE_CHECK = 'CHECK';
    const PAYMENT_MODE_OTHER = 'OTHER';
    const PAYMENT_MODE_CASH = 'CASH';
    const PAYMENT_MODE_CREDIT_CARD = 'CREDIT_CARD';
    const PAYMENT_MODE_BANK_TRANSFER = 'BANK_TRANSFER';

    protected $dates = ['created_at', 'updated_at', 'payment_date'];

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
        'invoice_id,',
        'branch_id'
    ];

    private function strposX($haystack, $needle, $number)
    {
        if ($number == '1') {
            return strpos($haystack, $needle);
        } elseif ($number > '1') {
            return strpos(
                $haystack,
                $needle,
                $this->strposX($haystack, $needle, $number - 1) + strlen($needle)
            );
        } else {
            return error_log('Error: Value for parameter $number is out of range');
        }
    }

    public function getPaymentNumAttribute()
    {
        $position = $this->strposX($this->payment_number, "-", 1) + 1;
        return substr($this->payment_number, $position);
    }

    public static function getNextPaymentNumber($value)
    {
        // Get the last created order
        $payment = Payment::where('payment_number', 'LIKE', $value . '-%')
                    ->orderBy('created_at', 'desc')
                    ->first();
        if (!$payment) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = explode("-",$payment->payment_number);
            $number = $number[1];
        }
        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.

        return sprintf('%06d', intval($number) + 1);
    }

    public function getPaymentPrefixAttribute ()
    {
        $prefix= explode("-",$this->payment_number)[0];
        return $prefix;
    }

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

    public function getFormattedCreatedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->created_at)->format($dateFormat);
    }

    public function getFormattedPaymentDateAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->payment_date)->format($dateFormat);
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

    public function scopeWhereUser($query, $user_id)
    {
        $query->where('payments.user_id', $user_id);
    }
}
