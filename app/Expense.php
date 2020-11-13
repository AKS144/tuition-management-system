<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Expense extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'expenses';

    protected $fillable = [
        'expense_category_id',
        'amount',
        'branch_id',
        'expense_date',
        'notes',
        'attachment_receipt'
    ];

    protected $appends = [
        'formattedExpenseDate',
        'formattedCreatedAt',
        'receipt'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('expenses.branch_id', $branch_id);
    }

    public function scopeWhereCategory($query, $categoryId)
    {
        return $query->where('expenses.expense_category_id', $categoryId);
    }

    public function scopeWhereNotes($query, $search)
    {
        $query->where('notes', 'LIKE', '%'.$search.'%');
    }

    public function scopeWhereCategoryName($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->whereHas('category', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%');
            });
        }
    }

    public function scopeExpensesBetween($query, $start, $end)
    {
        return $query->whereBetween(
            'expenses.expense_date',
            [$start->format('Y-m-d'), $end->format('Y-m-d')]
        );
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->whereHas('category', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%');
            })
            ->orWhere('notes', 'LIKE', '%'.$term.'%');
        }
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('expense_category_id')) {
            $query->whereCategory($filters->get('expense_category_id'));
        }

        if ($filters->get('from_date') && $filters->get('to_date')) {
            $start = Carbon::createFromFormat('d/m/Y', $filters->get('from_date'));
            $end = Carbon::createFromFormat('d/m/Y', $filters->get('to_date'));
            $query->expensesBetween($start, $end);
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'expense_date';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }

        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }
    }

    public function getFormattedExpenseDateAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->expense_date)->format($dateFormat);
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->created_at)->format($dateFormat);
    }

    public function getReceiptAttribute($value)
    {
        $media = $this->getFirstMedia('receipts');
        if($media) {
            return $media->getPath();
        }

        return null;
    }

    public function scopeExpensesAttributes($query)
    {
        $query->select(
            DB::raw('
                count(*) as expenses_count,
                sum(amount) as total_amount,
                expense_category_id'
            )
        )
        ->groupBy('expense_category_id');
    }
}
