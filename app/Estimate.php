<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EstimateItem;
use App\EstimateTemplate;
use App\Tax;

class Estimate extends Model
{
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_SENT = 'SENT';
    const STATUS_VIEWED = 'VIEWED';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_REJECTED = 'REJECTED';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'estimate_date',
        'expiry_date'
    ];

    protected $appends = [
        'formattedExpiryDate',
        'formattedEstimateDate'
    ];

    protected $fillable = [
        'estimate_date',
        'expiry_date',
        'estimate_number',
        'reference_number',
        'estimate_template_id',
        'discount',
        'discount_type',
        'discount_val',
        'status',
        'sub_total',
        'tax_per_item',
        'discount_per_item',
        'total',
        'tax',
        'notes',
        'unique_hash'
    ];

    protected $casts = [
        'total' => 'integer',
        'tax' => 'integer',
        'sub_total' => 'integer',
        'discount' => 'float',
        'discount_val' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(EstimateItem::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    public function estimateTemplate()
    {
        return $this->belongsTo(EstimateTemplate::class);
    }
}
