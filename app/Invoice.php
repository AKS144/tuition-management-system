<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvoiceTemplate;

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

    public function invoiceTemplate()
    {
        return $this->belongsTo(InvoiceTemplate::class);
    }
}
