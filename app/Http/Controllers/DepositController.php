<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        return view('deposit.index', $this->shell([
            'accounts' => array_values(array_filter(
                $this->bank()->accountsFor($this->customerId()),
                fn ($a) => $a['status'] === 'Active'
            )),
            'data' => session('deposit.details', []),
        ]));
    }

    public function review(Request $request)
    {
        $validated = $request->validate([
            'account_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);

        $account = $this->bank()->account((int) $validated['account_id']);
        if (! $account || $account['customer_id'] !== $this->customerId()) {
            return back()->withErrors(['account_id' => 'Please select one of your accounts.'])->withInput();
        }
        if ($account['status'] !== 'Active') {
            return back()->withErrors(['account_id' => 'That account is not active.'])->withInput();
        }

        session()->put('deposit.details', [
            'account_id' => $account['account_id'],
            'amount' => round((float) $validated['amount'], 2),
        ]);

        return view('deposit.confirm', $this->shell([
            'account' => $account,
            'amount' => round((float) $validated['amount'], 2),
        ]));
    }

    public function confirm(Request $request)
    {
        $details = session('deposit.details');
        if (! $details) {
            return redirect()->route('deposit.index');
        }

        $account = $this->bank()->account((int) $details['account_id']);
        if (! $account || $account['customer_id'] !== $this->customerId()) {
            return redirect()->route('deposit.index');
        }

        $result = $this->bank()->deposit($account['account_id'], $details['amount']);

        session()->forget('deposit.details');

        if (! $result['ok']) {
            session()->put('deposit.failure_reason', $result['reason']);

            return redirect()->route('deposit.failed');
        }

        session()->put('deposit.result', $result);

        return redirect()->route('deposit.success');
    }

    public function success()
    {
        $result = session('deposit.result');
        if (! $result) {
            return redirect()->route('deposit.index');
        }

        return view('deposit.success', $this->shell(['result' => $result]));
    }

    public function failed()
    {
        return view('deposit.failed', $this->shell([
            'reason' => session('deposit.failure_reason', 'The deposit could not be completed.'),
        ]));
    }
}
