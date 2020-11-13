<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseCategory;

class Expense extends Model
{
    protected $fillable = [
        'expense_category_id',
        'amount',
        'branch_id',
        'user_id',
        'expense_date',
        'notes',
        'attachment_receipt'
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
