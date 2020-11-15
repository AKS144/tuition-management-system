<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_SENT = 'SENT';
    const STATUS_VIEWED = 'VIEWED';
    const STATUS_OVERDUE = 'OVERDUE';
    const STATUS_COMPLETED = 'COMPLETED';

    const STATUS_UNPAID = 'UNPAID';
    const STATUS_PARTIALLY_PAID = 'PARTIALLY_PAID';
    const STATUS_PAID = 'PAID';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'invoice_date',
        'due_date'
    ];

    protected $casts = [
        'total' => 'integer',
        'tax' => 'integer',
        'sub_total' => 'integer',
        'discount' => 'float',
        'discount_val' => 'integer',
    ];

    protected $fillable = [
        'invoice_date',
        'due_date',
        'invoice_number',
        'reference_number',
        'invoice_template_id',
        'branch_id',
        'status',
        'paid_status',
        'sub_total',
        'tax_per_item',
        'discount_per_item',
        'total',
        'discount',
        'discount_type',
        'discount_val',
        'due_amount',
        'tax',
        'notes',
        'unique_hash',
        'sent',
        'viewed'
    ];

    protected $appends = [
        'formattedCreatedAt',
        'formattedInvoiceDate',
        'formattedDueDate'
    ];

    /**
     * Get the branch that owns the invoice.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the invoice template that owns the invoice.
     */
    public function invoiceTemplate()
    {
        return $this->belongsTo(InvoiceTemplate::class);
    }

    /**
     * Get the student that owns the invoice.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * The invoice items that belong to the invoices.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * The tax that belong to the invoices.
     */
    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    /**
     * The payments that belong to the invoices.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('invoices.branch_id', $branch_id);
    }

    public function scopeWhereStudent($query, $student_id)
    {
        $query->where('invoices.student_id', $student_id);
    }

    public function scopeWhereStatus($query, $status)
    {
        return $query->where('invoices.status', $status);
    }

    public function scopeWherePaidStatus($query, $status)
    {
        return $query->where('invoices.paid_status', $status);
    }

    public function scopeWhereInvoiceNumber($query, $invoiceNumber)
    {
        return $query->where('invoices.invoice_number', 'LIKE', '%'.$invoiceNumber.'%');
    }

    public function scopeInvoicesBetween($query, $start, $end)
    {
        return $query->whereBetween(
            'invoices.invoice_date',
            [$start->format('Y-m-d'), $end->format('Y-m-d')]
        );
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('status')) {
            if (
                $filters->get('status') == self::STATUS_UNPAID ||
                $filters->get('status') == self::STATUS_PARTIALLY_PAID ||
                $filters->get('status') == self::STATUS_PAID
            ) {
                $query->wherePaidStatus($filters->get('status'));
            } else {
                $query->whereStatus($filters->get('status'));
            }
        }

        if ($filters->get('paid_status')) {
            $query->wherePaidStatus($filters->get('status'));
        }

        if ($filters->get('invoice_number')) {
            $query->whereInvoiceNumber($filters->get('invoice_number'));
        }

        if ($filters->get('from_date') && $filters->get('to_date')) {
            $start = Carbon::createFromFormat('d/m/Y', $filters->get('from_date'));
            $end = Carbon::createFromFormat('d/m/Y', $filters->get('to_date'));
            $query->invoicesBetween($start, $end);
        }

        if ($filters->get('student_id')) {
            $query->whereStudent($filters->get('student_id'));
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'invoice_number';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }
    }

    public function getPreviousStatus()
    {
        if ($this->due_date < Carbon::now()) {
            return self::STATUS_OVERDUE;
        } elseif ($this->viewed) {
            return self::STATUS_VIEWED;
        } elseif ($this->sent) {
            return self::STATUS_SENT;
        } else {
            return self::STATUS_DRAFT;
        }
    }

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

    public function getInvoiceNumAttribute()
    {
        $position = $this->strposX($this->invoice_number, "-", 1) + 1;
        return substr($this->invoice_number, $position);
    }

    public function getInvoicePrefixAttribute () {
        $prefix = explode("-", $this->invoice_number)[0];
        return $prefix;
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->created_at)->format($dateFormat);
    }

    public function getFormattedDueDateAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->due_date)->format($dateFormat);
    }

    public function getFormattedInvoiceDateAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->invoice_date)->format($dateFormat);
    }

    public static function getNextInvoiceNumber($value)
    {
        // Get the last created order
        $lastOrder = Invoice::where('invoice_number', 'LIKE', $value . '-%')
                    ->orderBy('created_at', 'desc')
                    ->first();


        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = explode("-",$lastOrder->invoice_number);
            $number = $number[1];
        }
        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %06d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.

        return sprintf('%06d', intval($number) + 1);
    }
}
