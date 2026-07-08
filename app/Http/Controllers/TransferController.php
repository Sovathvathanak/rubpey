<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class TransferController extends Controller
{
    /** Step 1 — pick the source account (or head to deposit). */
    public function initiate()
    {
        $bank = $this->bank();
        $customerId = $this->customerId();
        $accounts = $bank->accountsFor($customerId);
        $sourceId = (int) session('transfer.source_id');
        $source = collect($accounts)->firstWhere('account_id', $sourceId);

        $recent = collect($bank->transactionsFor($customerId))
            ->filter(fn ($t) => $t['amount'] < 0 && str_starts_with($t['description'], 'Transfer to'))
            ->take(3)
            ->values();

        return view('transfers.initiate', $this->shell([
            'accounts' => $accounts,
            'source' => $source,
            'recentTransfers' => $recent,
        ]));
    }

    public function chooseSource(Request $request)
    {
        $validated = $request->validate(['source_account_id' => ['required', 'integer']]);
        $account = $this->bank()->account((int) $validated['source_account_id']);

        if (! $account || $account['customer_id'] !== $this->customerId()) {
            return back()->withErrors(['source_account_id' => 'Please select one of your accounts.']);
        }
        if ($account['status'] !== 'Active') {
            return back()->withErrors(['source_account_id' => 'That account is ' . strtolower($account['status']) . ' and cannot send transfers.']);
        }

        session()->put('transfer.source_id', $account['account_id']);

        return redirect()->route('transfers.details');
    }

    /** Step 2 — recipient, amount, remark. */
    public function details()
    {
        $source = $this->sourceOrRedirect();
        if (! is_array($source)) {
            return $source;
        }

        return view('transfers.details', $this->shell([
            'source' => $source,
            'data' => session('transfer.details', []),
        ]));
    }

    public function postDetails(Request $request)
    {
        $source = $this->sourceOrRedirect();
        if (! is_array($source)) {
            return $source;
        }

        $validated = $request->validate([
            'recipient_account_number' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'remark' => ['nullable', 'string', 'max:255'],
        ]);

        $recipient = $this->bank()->findAccountByNumber($validated['recipient_account_number']);
        if (! $recipient) {
            return back()->withErrors(['recipient_account_number' => 'No account matches that number.'])->withInput();
        }
        if ($recipient['account_id'] === $source['account_id']) {
            return back()->withErrors(['recipient_account_number' => 'Source and destination accounts must be different.'])->withInput();
        }

        session()->put('transfer.details', [
            'recipient_account_number' => $recipient['account_number'],
            'amount' => round((float) $validated['amount'], 2),
            'remark' => $validated['remark'] ?? '',
        ]);

        return redirect()->route('transfers.review');
    }

    /** Step 3 — review + PIN confirm. */
    public function review()
    {
        $source = $this->sourceOrRedirect();
        if (! is_array($source)) {
            return $source;
        }
        $details = session('transfer.details');
        if (! $details) {
            return redirect()->route('transfers.details');
        }

        $recipient = $this->bank()->findAccountByNumber($details['recipient_account_number']);
        $recipientCustomer = $recipient ? $this->bank()->customer($recipient['customer_id']) : null;

        return view('transfers.review', $this->shell([
            'source' => $source,
            'details' => $details,
            'recipient' => $recipient,
            'recipientCustomer' => $recipientCustomer,
        ]));
    }

    public function confirm(Request $request)
    {
        $source = $this->sourceOrRedirect();
        if (! is_array($source)) {
            return $source;
        }
        $details = session('transfer.details');
        if (! $details) {
            return redirect()->route('transfers.details');
        }

        $validated = $request->validate(['pin' => ['required', 'string']]);

        $throttleKey = 'pin-confirm:' . $this->customerId();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors(['pin' => 'Too many PIN attempts. Try again in ' . RateLimiter::availableIn($throttleKey) . ' seconds.']);
        }

        if (! Hash::check($validated['pin'], $this->customer()['pin_number'])) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors(['pin' => 'Incorrect PIN. Please try again.']);
        }
        RateLimiter::clear($throttleKey);

        $result = $this->bank()->transfer(
            $source['account_id'],
            $details['recipient_account_number'],
            $details['amount'],
            $details['remark'],
        );

        if (! $result['ok']) {
            session()->put('transfer.failure_reason', $result['reason']);

            return redirect()->route('transfers.failed');
        }

        session()->forget(['transfer.source_id', 'transfer.details']);
        session()->put('transfer.result', $result);

        return redirect()->route('transfers.success');
    }

    public function success()
    {
        $result = session('transfer.result');
        if (! $result) {
            return redirect()->route('transfers.initiate');
        }

        return view('transfers.success', $this->shell(['result' => $result]));
    }

    public function failed()
    {
        return view('transfers.failed', $this->shell([
            'reason' => session('transfer.failure_reason', 'The transfer could not be completed.'),
        ]));
    }

    private function sourceOrRedirect()
    {
        $sourceId = (int) session('transfer.source_id');
        $account = $sourceId ? $this->bank()->account($sourceId) : null;

        if (! $account || $account['customer_id'] !== $this->customerId()) {
            return redirect()->route('transfers.initiate');
        }

        return $account;
    }
}
