<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $bank = $this->bank();
        $customerId = $this->customerId();

        $from = $request->query('from');
        $to = $request->query('to');
        $status = $request->query('status', 'all');

        $all = $bank->transactionsFor($customerId, $from, $to, $status);

        $perPage = 8;
        $page = max(1, (int) $request->query('page', 1));
        $total = count($all);
        $rows = array_slice($all, ($page - 1) * $perPage, $perPage);

        $accountsById = collect($bank->accountsFor($customerId))->keyBy('account_id');
        $transfersById = collect($all)->pluck('transfer_id')->filter()->unique()
            ->mapWithKeys(fn ($id) => [$id => $bank->transferById($id)['reference_code'] ?? null]);

        return view('transactions.index', $this->shell([
            'transactions' => $rows,
            'accountsById' => $accountsById,
            'transfersById' => $transfersById,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'lastPage' => max(1, (int) ceil($total / $perPage)),
            'filters' => ['from' => $from, 'to' => $to, 'status' => $status],
        ]));
    }
}
