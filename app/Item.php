<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
Use App\InvoiceItem;

class Item extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'price',
        'branch_id',
        'description',
        'unit_id',
    ];

    protected $casts = [
        'price' => 'integer'
    ];

    protected $appends = [
        'formattedCreatedAt'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The invoice items that belong to the item.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * The taxe items that belong to the item.
     */
    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('branch_id', $branch_id);
    }

    public static function deleteItem($id)
    {
        $item = Item::find($id);

        if ($item->taxes()->exists() && $item->taxes()->count() > 0) {
            return false;
        }

        if ($item->invoiceItems()->exists() && $item->invoiceItems()->count() > 0) {
            return false;
        }

        $item->delete();

        return true;
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->created_at)->format($dateFormat);
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }

        if ($filters->get('price')) {
            $query->wherePrice($filters->get('price'));
        }

        if ($filters->get('unit_id')) {
            $query->whereUnit($filters->get('unit_id'));
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'name';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeWhereUnit($query, $unit_id)
    {
        return $query->where('items.unit_id', $unit_id);
    }

    public function scopeWhereSearch($query, $search)
    {
        return $query->where('items.name', 'LIKE', '%'.$search.'%');
    }

    public function scopeWherePrice($query, $price)
    {
        return $query->where('items.price', $price);
    }
}
