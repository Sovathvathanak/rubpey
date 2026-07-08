<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $bank = $this->bank();
        $customerId = $this->customerId();
        $accounts = $bank->accountsFor($customerId);

        $active = array_filter($accounts, fn ($a) => $a['status'] === 'Active');
        $totalBalance = array_sum(array_map(
            fn ($a) => $a['currency'] === 'USD' ? $a['balance'] : 0,
            $active
        ));
        $types = implode(', ', array_unique(array_column($active, 'account_type')));

        return view('dashboard', $this->shell([
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
            'activeCount' => count($active),
            'accountTypes' => $types,
            'recentTransactions' => $bank->recentTransactionsFor($customerId, 5),
            'accountsById' => collect($bank->accountsFor($customerId))->keyBy('account_id'),
        ]));
    }
}
