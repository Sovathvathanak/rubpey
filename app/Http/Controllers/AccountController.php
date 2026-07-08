<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $bank = $this->bank();
        $customerId = $this->customerId();
        $accounts = $bank->accountsFor($customerId);
        $active = array_filter($accounts, fn ($a) => $a['status'] === 'Active');

        return view('accounts.index', $this->shell([
            'accounts' => $accounts,
            'totalBalance' => array_sum(array_map(fn ($a) => $a['currency'] === 'USD' ? $a['balance'] : 0, $active)),
            'activeCount' => count($active),
            'spending' => $bank->spendingFor($customerId),
        ]));
    }

    public function create()
    {
        return view('accounts.create', $this->shell());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => ['required', 'string', 'max:50'],
            'account_type' => ['required', 'in:Savings,Checking'],
            'currency' => ['required', 'in:USD,KHR'],
        ]);

        $account = $this->bank()->createAccount(
            $this->customerId(),
            $validated['account_name'],
            $validated['account_type'],
            $validated['currency'],
        );

        return redirect()->route('accounts.created', $account['account_id']);
    }

    public function created(int $accountId)
    {
        $account = $this->authorizeAccount($accountId);

        return view('accounts.created', $this->shell(['account' => $account]));
    }

    public function show(int $accountId)
    {
        $account = $this->authorizeAccount($accountId);
        $transactions = array_values(array_filter(
            $this->bank()->transactionsFor($this->customerId()),
            fn ($t) => $t['account_id'] === $accountId
        ));

        return view('accounts.show', $this->shell([
            'account' => $account,
            'transactions' => array_slice($transactions, 0, 5),
        ]));
    }

    private function authorizeAccount(int $accountId): array
    {
        $account = $this->bank()->account($accountId);
        abort_if(! $account || $account['customer_id'] !== $this->customerId(), 404);

        return $account;
    }
}
