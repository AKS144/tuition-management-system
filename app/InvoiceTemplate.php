<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;
use App\InvoiceTemplate;

class InvoiceTemplate extends Model
{
    protected $fillable = ['path', 'view', 'name'];

    public function getPathAttribute($value)
    {
        return url($value);
    }

    /**
     * Get the invoice associated with the invoice template
     */
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
