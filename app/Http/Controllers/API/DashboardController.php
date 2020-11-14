<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Invoice;
use App\BranchSetting;
use App\Expense;
use App\Payment;
use App\Student;
use App\User;

class DashboardController extends Controller
{
    /**
     * Retrieve Dashboard details
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $invoiceTotals = [];
        $expenseTotals = [];
        $receiptTotals = [];
        $netProfits = [];
        $i = 0;
        $months = [];
        $monthEnds = [];
        $monthCounter = 0;
        $fiscalYear = BranchSetting::getSetting('fiscal_year', $request->header('branch'));
        $startDate = Carbon::now();
        $start = Carbon::now();
        $end = Carbon::now();
        $terms = explode('-', $fiscalYear);

        if ($terms[0] <= $start->month) {
            $startDate->month($terms[0])->startOfMonth();
            $start->month($terms[0])->startOfMonth();
            $end->month($terms[0])->endOfMonth();
        } else {
            $startDate->subYear()->month($terms[0])->startOfMonth();
            $start->subYear()->month($terms[0])->startOfMonth();
            $end->subYear()->month($terms[0])->endOfMonth();
        }

        if ($request->has('previous_year')) {
            $startDate->subYear()->startOfMonth();
            $start->subYear()->startOfMonth();
            $end->subYear()->endOfMonth();
        }

        while ($monthCounter < 12) {
            array_push(
                $invoiceTotals,
                Invoice::whereBetween(
                    'invoice_date',
                    [$start->format('Y-m-d'), $end->format('Y-m-d')]
                )
                ->whereBranch($request->header('branch'))
                ->sum('total')
            );
            array_push(
                $expenseTotals,
                Expense::whereBetween(
                    'expense_date',
                    [$start->format('Y-m-d'), $end->format('Y-m-d')]
                )
                ->whereBranch($request->header('branch'))
                ->sum('amount')
            );
            array_push(
                $receiptTotals,
                Payment::whereBetween(
                    'payment_date',
                    [$start->format('Y-m-d'), $end->format('Y-m-d')]
                )
                ->whereBranch($request->header('branch'))
                ->sum('amount')
            );
            array_push(
                $netProfits,
                ($receiptTotals[$i] - $expenseTotals[$i])
            );
            $i++;
            array_push($months, $start->format('M'));
            $monthCounter++;
            $end->startOfMonth();
            $start->addMonth()->startOfMonth();
            $end->addMonth()->endOfMonth();
        }

        $start->subMonth()->endOfMonth();

        $salesTotal = Invoice::whereBranch($request->header('branch'))
            ->whereBetween(
                'invoice_date',
                [$startDate->format('Y-m-d'), $start->format('Y-m-d')]
            )
            ->sum('total');
        $totalReceipts = Payment::whereBranch($request->header('branch'))
            ->whereBetween(
                'payment_date',
                [$startDate->format('Y-m-d'), $start->format('Y-m-d')]
            )
            ->sum('amount');
        $totalExpenses = Expense::whereBranch($request->header('branch'))
            ->whereBetween(
                'expense_date',
                [$startDate->format('Y-m-d'), $start->format('Y-m-d')]
            )
            ->sum('amount');
        $netProfit = (int)$totalReceipts - (int)$totalExpenses;

        $chartData = [
            'months'        => $months,
            'invoiceTotals' => $invoiceTotals,
            'expenseTotals' => $expenseTotals,
            'receiptTotals' => $receiptTotals,
            'netProfits'    => $netProfits
        ];

        $studentsCount = Student::whereBranch($request->header('branch'))->get()->count();
        $invoicesCount = Invoice::whereBranch($request->header('branch'))->get()->count();
        $expensesCount = Expense::get()->count();
        $totalDueAmount = Invoice::whereBranch($request->header('branch'))->sum('due_amount');
        $dueInvoices = Invoice::with('user')->whereBranch($request->header('branch'))->where('due_amount', '>', 0)->take(5)->latest()->get();
        $expenses = Expense::take(5)->latest()->get();

        return response()->json([
            'dueInvoices' => $dueInvoices,
            'expenses' => $expenses,
            'expensesCount' => $expensesCount,
            'totalDueAmount' => $totalDueAmount,
            'invoicesCount' => $invoicesCount,
            'studentsCount' => $studentsCount,
            'chartData' => $chartData,
            'salesTotal' => $salesTotal,
            'totalReceipts' => $totalReceipts,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit
        ]);
    }
}
