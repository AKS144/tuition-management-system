<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaxType;
use App\Invoice;
use App\Item;
use App\InvoiceItem;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'branch_id',
        'percent',
        'tax_type_id',
        'invoice_id',
        'item_id',
        'compound_tax'
    ];

    protected $casts = [
        'amount' => 'integer',
        'percent' => 'float'
    ];

    public function taxType()
    {
        return $this->belongsTo(TaxType::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function invoiceItem()
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class);
    }
}
