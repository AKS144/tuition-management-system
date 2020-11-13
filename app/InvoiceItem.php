<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;
use App\Item;
use App\Tax;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'item_id',
        'description',
        'branch_id',
        'quantity',
        'price',
        'discount_type',
        'discount_val',
        'total',
        'tax',
        'discount'
    ];

    protected $casts = [
        'price' => 'integer',
        'total' => 'integer',
        'discount' => 'float',
        'quantity' => 'float',
        'discount_val' => 'integer',
        'tax' => 'integer'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }
}
