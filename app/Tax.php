<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaxType;
use App\Invoice;
use App\Estimate;
use App\Item;
use App\InvoiceItem;
use App\EstimateItem;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'company_id',
        'percent',
        'tax_type_id',
        'invoice_id',
        'estimate_id',
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

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function invoiceItem()
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function estimateItem()
    {
        return $this->belongsTo(EstimateItem::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
