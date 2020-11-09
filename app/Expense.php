<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseCategory;

class Expense extends Model
{
    protected $fillable = [
        'expense_category_id',
        'amount',
        'company_id',
        'user_id',
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
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
