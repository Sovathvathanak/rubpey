<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Session-backed stand-in for the db_bank_mng database.
 *
 * Data shapes mirror the real schema (tb_customers, tb_accounts,
 * tb_transfers, tb_transaction_hts) so controllers can later swap
 * these methods for DB::transaction() queries without reshaping views.
 */
class MockBank
{
    private const KEY = 'bank';

    /** Bcrypt of "123456" — every seeded customer uses this PIN. */
    private const DEMO_PIN_HASH = '$2y$12$MxyGDawqIgZBZBz2rJQpq.TSY9Iu1Mkf/fcyWtmMz84yXery1U6Ru';

    private array $data;

    public function __construct()
    {
        $this->data = Session::get(self::KEY) ?? $this->seed();
    }

    private function persist(): void
    {
        Session::put(self::KEY, $this->data);
    }

    private function seed(): array
    {
        $now = now();

        $customers = [];
        $seedCustomers = [
            [1, 'Layhout', 'Tang', '001122334', '+855 12 662 933', 'layhout@gmail.com', 'Cambodia', '1978-05-14', 'Trolok Bek Street 598, Phnom Penh 120000'],
            [2, 'Kimkuy', 'Ngo', '002233445', '+855 96 555 220', 'kimkuy@gmail.com', 'Cambodia', '1990-09-02', 'St. 271, Toul Kork, Phnom Penh'],
            [3, 'Sovanmony', 'Reaksmey', '003344556', '+855 77 889 001', 'sovanmony@gmail.com', 'Cambodia', '1995-01-21', 'National Road 5, Battambang'],
            [4, 'Sovathvathanak', 'Meung', '004455667', '+855 10 234 567', 'sovathvathanak@gmail.com', 'Cambodia', '2001-11-30', 'St. 2004, Sen Sok, Phnom Penh'],
            [5, 'Vinchhou', 'Phea', '005566778', '+855 69 777 888', 'vinchhou@gmail.com', 'Cambodia', '1988-03-17', 'Riverside, Siem Reap'],
            [6, 'Kimlong', 'Oeun', '006677889', '+855 15 998 001', 'kimlong.oeun@gmail.com', 'Cambodia', '1993-07-08', 'St. 320, Chamkarmon, Phnom Penh'],
            [7, 'Tangkea', 'Suy', '007788990', '+855 88 445 112', 'tangkea.suy@gmail.com', 'Cambodia', '1985-02-25', 'Wat Bo Road, Siem Reap'],
        ];
        foreach ($seedCustomers as [$id, $first, $last, $nid, $phone, $email, $nat, $dob, $address]) {
            $customers[$id] = [
                'customer_id' => $id,
                'first_name' => $first,
                'last_name' => $last,
                'password' => self::DEMO_PIN_HASH,
                'pin_number' => self::DEMO_PIN_HASH,
                'national_id' => $nid,
                'nationality' => $nat,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'data_of_birth' => $dob,
                'customer_code' => 'USR-' . (183090 + $id),
                'last_login' => $now->copy()->subDays(1)->format('Y-m-d H:i:s'),
                'created_at' => $now->copy()->subMonths(6)->format('Y-m-d H:i:s'),
            ];
        }

        $accounts = [];
        $seedAccounts = [
            [1, 1, 'Savings', '001-1000001', 12450.00, 'Active', 'USD', 'Main Savings'],
            [2, 1, 'Checking', '001-1000002', 3200.50, 'Active', 'USD', 'Daily Checking'],
            [3, 2, 'Savings', '001-2000001', 8750.00, 'Active', 'USD', 'Kimkuy Savings'],
            [4, 3, 'Savings', '001-3000001', 1500000.00, 'Active', 'KHR', 'Riel Savings'],
            [5, 4, 'Checking', '001-4000001', 5600.75, 'Active', 'USD', 'Sovathvathanak Checking'],
            [6, 5, 'Savings', '001-5000001', 940.00, 'Frozen', 'USD', 'Phea Savings'],
            [7, 6, 'Savings', '001-6000001', 3400.25, 'Active', 'USD', 'Kimlong Savings'],
            [8, 6, 'Checking', '001-6000002', 780.00, 'Active', 'USD', 'Kimlong Checking'],
            [9, 7, 'Savings', '001-7000001', 2200000.00, 'Active', 'KHR', 'Tangkea Riel Savings'],
            [10, 7, 'Checking', '001-7000002', 610.40, 'Active', 'USD', 'Tangkea Checking'],
        ];
        foreach ($seedAccounts as [$id, $cid, $type, $number, $balance, $status, $currency, $name]) {
            $accounts[$id] = [
                'account_id' => $id,
                'customer_id' => $cid,
                'account_type' => $type,
                'account_number' => $number,
                'balance' => $balance,
                'status' => $status,
                'currency' => $currency,
                'account_name' => $name,
            ];
        }

        $transfers = [
            1 => ['transfer_id' => 1, 'from_account_id' => 1, 'to_account_id' => 3, 'amount' => 250.00, 'reference_code' => 'TRX-88910-KLA', 'transfer_date' => $now->copy()->subDays(3)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            2 => ['transfer_id' => 2, 'from_account_id' => null, 'to_account_id' => 2, 'amount' => 1200.00, 'reference_code' => 'TRX-88772-BAQ', 'transfer_date' => $now->copy()->subDays(5)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            3 => ['transfer_id' => 3, 'from_account_id' => 2, 'to_account_id' => 5, 'amount' => 500.00, 'reference_code' => 'TRX-88905-CXD', 'transfer_date' => $now->copy()->subDays(1)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            4 => ['transfer_id' => 4, 'from_account_id' => 8, 'to_account_id' => 3, 'amount' => 300.00, 'reference_code' => 'TRX-89010-DFE', 'transfer_date' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            5 => ['transfer_id' => 5, 'from_account_id' => null, 'to_account_id' => 9, 'amount' => 500000.00, 'reference_code' => 'TRX-89044-GHK', 'transfer_date' => $now->copy()->subDays(4)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            6 => ['transfer_id' => 6, 'from_account_id' => 10, 'to_account_id' => 1, 'amount' => 150.00, 'reference_code' => 'TRX-89100-JKL', 'transfer_date' => $now->copy()->subHours(12)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
        ];

        $transactions = [
            1 => ['transaction_id' => 1, 'account_id' => 1, 'transfer_id' => 1, 'amount' => -250.00, 'description' => 'Transfer to Kimkuy Ngo', 'transfer_date' => $now->copy()->subDays(3)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            2 => ['transaction_id' => 2, 'account_id' => 3, 'transfer_id' => 1, 'amount' => 250.00, 'description' => 'Transfer from Layhout Tang', 'transfer_date' => $now->copy()->subDays(3)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            3 => ['transaction_id' => 3, 'account_id' => 2, 'transfer_id' => 2, 'amount' => 1200.00, 'description' => 'Deposit', 'transfer_date' => $now->copy()->subDays(5)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            4 => ['transaction_id' => 4, 'account_id' => 2, 'transfer_id' => 3, 'amount' => -500.00, 'description' => 'Transfer to Sovathvathanak Meung', 'transfer_date' => $now->copy()->subDays(1)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            5 => ['transaction_id' => 5, 'account_id' => 5, 'transfer_id' => 3, 'amount' => 500.00, 'description' => 'Transfer from Layhout Tang', 'transfer_date' => $now->copy()->subDays(1)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            6 => ['transaction_id' => 6, 'account_id' => 8, 'transfer_id' => 4, 'amount' => -300.00, 'description' => 'Transfer to Kimkuy Ngo', 'transfer_date' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            7 => ['transaction_id' => 7, 'account_id' => 3, 'transfer_id' => 4, 'amount' => 300.00, 'description' => 'Transfer from Kimlong Oeun', 'transfer_date' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            8 => ['transaction_id' => 8, 'account_id' => 9, 'transfer_id' => 5, 'amount' => 500000.00, 'description' => 'Deposit', 'transfer_date' => $now->copy()->subDays(4)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            9 => ['transaction_id' => 9, 'account_id' => 10, 'transfer_id' => 6, 'amount' => -150.00, 'description' => 'Transfer to Layhout Tang', 'transfer_date' => $now->copy()->subHours(12)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
            10 => ['transaction_id' => 10, 'account_id' => 1, 'transfer_id' => 6, 'amount' => 150.00, 'description' => 'Transfer from Tangkea Suy', 'transfer_date' => $now->copy()->subHours(12)->format('Y-m-d H:i:s'), 'status' => 'Completed'],
        ];

        $activities = [
            1 => ['activity_id' => 1, 'customer_id' => 1, 'title' => 'Incoming Wire Transfer', 'body' => "Received \$1,200.00 deposit into 'Daily Checking'.", 'icon' => 'transfer', 'date' => $now->copy()->subDays(5)->format('Y-m-d H:i:s'), 'read' => false],
            2 => ['activity_id' => 2, 'customer_id' => 1, 'title' => 'Password Successfully Changed', 'body' => 'Your PIN was updated. This action requires no further verification.', 'icon' => 'security', 'date' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'), 'read' => false],
            3 => ['activity_id' => 3, 'customer_id' => 6, 'title' => 'Account Created', 'body' => 'Welcome to RubPey! Your customer profile was created successfully.', 'icon' => 'security', 'date' => $now->copy()->subDays(6)->format('Y-m-d H:i:s'), 'read' => true],
            4 => ['activity_id' => 4, 'customer_id' => 7, 'title' => 'Account Created', 'body' => 'Welcome to RubPey! Your customer profile was created successfully.', 'icon' => 'security', 'date' => $now->copy()->subDays(3)->format('Y-m-d H:i:s'), 'read' => true],
            5 => ['activity_id' => 5, 'customer_id' => 2, 'title' => 'Incoming Transfer', 'body' => "Received \$300.00 from Kimlong Oeun (Ref TRX-89010-DFE).", 'icon' => 'transfer', 'date' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'), 'read' => false],
            6 => ['activity_id' => 6, 'customer_id' => 1, 'title' => 'Incoming Transfer', 'body' => "Received \$150.00 from Tangkea Suy (Ref TRX-89100-JKL).", 'icon' => 'transfer', 'date' => $now->copy()->subHours(12)->format('Y-m-d H:i:s'), 'read' => false],
        ];

        $this->data = [
            'customers' => $customers,
            'accounts' => $accounts,
            'transfers' => $transfers,
            'transactions' => $transactions,
            'activities' => $activities,
            'seq' => ['customer' => 8, 'account' => 11, 'transfer' => 7, 'transaction' => 11, 'activity' => 7],
        ];
        $this->persist();

        return $this->data;
    }

    private function nextId(string $type): int
    {
        return $this->data['seq'][$type]++;
    }

    /* ---------------- customers ---------------- */

    public function findCustomerByNationalId(string $nationalId): ?array
    {
        foreach ($this->data['customers'] as $c) {
            if ($c['national_id'] === $nationalId) {
                return $c;
            }
        }

        return null;
    }

    public function customer(int $id): ?array
    {
        return $this->data['customers'][$id] ?? null;
    }

    public function emailExists(string $email): bool
    {
        return collect($this->data['customers'])->contains(fn ($c) => strcasecmp($c['email'], $email) === 0);
    }

    public function createCustomer(array $attrs): array
    {
        $id = $this->nextId('customer');
        $customer = [
            'customer_id' => $id,
            'first_name' => $attrs['first_name'],
            'last_name' => $attrs['last_name'],
            'password' => Hash::make($attrs['pin']),
            'pin_number' => Hash::make($attrs['pin']),
            'national_id' => $attrs['national_id'],
            'nationality' => $attrs['nationality'] ?? 'Cambodia',
            'phone' => $attrs['phone'],
            'email' => $attrs['email'],
            'address' => $attrs['address'],
            'data_of_birth' => $attrs['data_of_birth'],
            'customer_code' => 'USR-' . random_int(100000, 999999),
            'last_login' => now()->format('Y-m-d H:i:s'),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];
        $this->data['customers'][$id] = $customer;
        $this->logActivity($id, 'Account Created', 'Welcome to RubPey! Your customer profile was created successfully.', 'security');
        $this->persist();

        return $customer;
    }

    public function updateCustomer(int $id, array $attrs): void
    {
        foreach (['first_name', 'last_name', 'email', 'phone', 'address'] as $field) {
            if (array_key_exists($field, $attrs)) {
                $this->data['customers'][$id][$field] = $attrs[$field];
            }
        }
        $this->persist();
    }

    public function updatePinByIdentity(string $nationalId, string $phone, string $newPin): bool
    {
        foreach ($this->data['customers'] as $id => $c) {
            if ($c['national_id'] === $nationalId && preg_replace('/\D/', '', $c['phone']) === preg_replace('/\D/', '', $phone)) {
                $this->data['customers'][$id]['pin_number'] = Hash::make($newPin);
                $this->logActivity($id, 'PIN Successfully Changed', 'Your PIN was reset via identity verification.', 'security');
                $this->persist();

                return true;
            }
        }

        return false;
    }

    public function touchLastLogin(int $id): void
    {
        $this->data['customers'][$id]['last_login'] = now()->format('Y-m-d H:i:s');
        $this->persist();
    }

    /* ---------------- accounts ---------------- */

    public function accountsFor(int $customerId): array
    {
        return array_values(array_filter($this->data['accounts'], fn ($a) => $a['customer_id'] === $customerId));
    }

    public function account(int $accountId): ?array
    {
        return $this->data['accounts'][$accountId] ?? null;
    }

    public function findAccountByNumber(string $number): ?array
    {
        foreach ($this->data['accounts'] as $a) {
            if ($a['account_number'] === trim($number)) {
                return $a;
            }
        }

        return null;
    }

    public function createAccount(int $customerId, string $name, string $type, string $currency): array
    {
        $id = $this->nextId('account');
        $account = [
            'account_id' => $id,
            'customer_id' => $customerId,
            'account_type' => $type,
            'account_number' => sprintf('001-%d00%04d', $customerId, $id),
            'balance' => 0.00,
            'status' => 'Active',
            'currency' => $currency,
            'account_name' => $name,
        ];
        $this->data['accounts'][$id] = $account;
        $this->logActivity($customerId, 'New Account Opened', "'{$name}' ({$type}, {$currency}) was created with a starting balance of 0.00.", 'account');
        $this->persist();

        return $account;
    }

    /* ---------------- money movement ---------------- */

    public function deposit(int $accountId, float $amount): array
    {
        $account = $this->account($accountId);

        if (! $account) {
            return ['ok' => false, 'reason' => 'Destination account not found.'];
        }
        if ($account['status'] !== 'Active') {
            return ['ok' => false, 'reason' => 'Destination account is not active.'];
        }
        if ($amount <= 0) {
            return ['ok' => false, 'reason' => 'Deposit amount must be greater than zero.'];
        }

        $amount = round($amount, 2);
        $now = now()->format('Y-m-d H:i:s');
        $ref = $this->makeReference();

        $transferId = $this->nextId('transfer');
        $this->data['transfers'][$transferId] = [
            'transfer_id' => $transferId,
            'from_account_id' => null,
            'to_account_id' => $accountId,
            'amount' => $amount,
            'reference_code' => $ref,
            'transfer_date' => $now,
            'status' => 'Completed',
        ];

        $txId = $this->nextId('transaction');
        $this->data['transactions'][$txId] = [
            'transaction_id' => $txId,
            'account_id' => $accountId,
            'transfer_id' => $transferId,
            'amount' => $amount,
            'description' => 'Deposit',
            'transfer_date' => $now,
            'status' => 'Completed',
        ];

        $this->data['accounts'][$accountId]['balance'] = round($this->data['accounts'][$accountId]['balance'] + $amount, 2);

        $this->logActivity($account['customer_id'], 'Deposit Received', sprintf("Deposited %s into '%s'.", $this->money($amount, $account['currency']), $account['account_name']), 'transfer');
        $this->persist();

        return [
            'ok' => true,
            'reference_code' => $ref,
            'transfer_date' => $now,
            'amount' => $amount,
            'new_balance' => $this->data['accounts'][$accountId]['balance'],
            'account' => $this->data['accounts'][$accountId],
        ];
    }

    public function transfer(int $fromAccountId, string $toAccountNumber, float $amount, string $remark = ''): array
    {
        $from = $this->account($fromAccountId);
        $to = $this->findAccountByNumber($toAccountNumber);
        $amount = round($amount, 2);
        $now = now()->format('Y-m-d H:i:s');

        $fail = function (string $reason) use ($from, $to, $amount, $now) {
            // record the failed attempt like the real schema would (status Failed, no balance change)
            $transferId = $this->nextId('transfer');
            $this->data['transfers'][$transferId] = [
                'transfer_id' => $transferId,
                'from_account_id' => $from['account_id'] ?? null,
                'to_account_id' => $to['account_id'] ?? null,
                'amount' => $amount,
                'reference_code' => $this->makeReference(),
                'transfer_date' => $now,
                'status' => 'Failed',
            ];
            if ($from) {
                $txId = $this->nextId('transaction');
                $this->data['transactions'][$txId] = [
                    'transaction_id' => $txId,
                    'account_id' => $from['account_id'],
                    'transfer_id' => $transferId,
                    'amount' => -$amount,
                    'description' => 'Failed Transfer: ' . $reason,
                    'transfer_date' => $now,
                    'status' => 'Failed',
                ];
            }
            $this->persist();

            return ['ok' => false, 'reason' => $reason];
        };

        if (! $from) {
            return ['ok' => false, 'reason' => 'Source account not found.'];
        }
        if (! $to) {
            return $fail('The destination account number could not be verified.');
        }
        if ($from['account_id'] === $to['account_id']) {
            return $fail('Source and destination accounts must be different.');
        }
        if ($from['status'] !== 'Active') {
            return $fail('The source account is not active.');
        }
        if ($to['status'] !== 'Active') {
            return $fail('The destination account is not active.');
        }
        if ($amount <= 0) {
            return $fail('Transfer amount must be greater than zero.');
        }
        if ($from['currency'] !== $to['currency']) {
            return $fail('Cross-currency transfers are not supported. Both accounts must use the same currency.');
        }
        if ($from['balance'] < $amount) {
            return $fail('The current balance in your account is lower than the requested transfer amount.');
        }

        $ref = $this->makeReference();
        $transferId = $this->nextId('transfer');
        $this->data['transfers'][$transferId] = [
            'transfer_id' => $transferId,
            'from_account_id' => $from['account_id'],
            'to_account_id' => $to['account_id'],
            'amount' => $amount,
            'reference_code' => $ref,
            'transfer_date' => $now,
            'status' => 'Completed',
        ];

        $toCustomer = $this->customer($to['customer_id']);
        $fromCustomer = $this->customer($from['customer_id']);

        $txOut = $this->nextId('transaction');
        $this->data['transactions'][$txOut] = [
            'transaction_id' => $txOut,
            'account_id' => $from['account_id'],
            'transfer_id' => $transferId,
            'amount' => -$amount,
            'description' => sprintf('Transfer to %s %s%s', $toCustomer['first_name'], $toCustomer['last_name'], $remark !== '' ? ' — ' . $remark : ''),
            'transfer_date' => $now,
            'status' => 'Completed',
        ];

        $txIn = $this->nextId('transaction');
        $this->data['transactions'][$txIn] = [
            'transaction_id' => $txIn,
            'account_id' => $to['account_id'],
            'transfer_id' => $transferId,
            'amount' => $amount,
            'description' => sprintf('Transfer from %s %s%s', $fromCustomer['first_name'], $fromCustomer['last_name'], $remark !== '' ? ' — ' . $remark : ''),
            'transfer_date' => $now,
            'status' => 'Completed',
        ];

        $this->data['accounts'][$from['account_id']]['balance'] = round($from['balance'] - $amount, 2);
        $this->data['accounts'][$to['account_id']]['balance'] = round($to['balance'] + $amount, 2);

        $this->logActivity($from['customer_id'], 'Transfer Sent', sprintf('Sent %s to %s %s (Ref %s).', $this->money($amount, $from['currency']), $toCustomer['first_name'], $toCustomer['last_name'], $ref), 'transfer');
        $this->logActivity($to['customer_id'], 'Incoming Transfer', sprintf('Received %s from %s %s (Ref %s).', $this->money($amount, $to['currency']), $fromCustomer['first_name'], $fromCustomer['last_name'], $ref), 'transfer');
        $this->persist();

        return [
            'ok' => true,
            'reference_code' => $ref,
            'transfer_date' => $now,
            'amount' => $amount,
            'new_balance' => $this->data['accounts'][$from['account_id']]['balance'],
            'from' => $this->data['accounts'][$from['account_id']],
            'to' => $this->data['accounts'][$to['account_id']],
            'to_customer' => $toCustomer,
        ];
    }

    /* ---------------- reads ---------------- */

    public function transactionsFor(int $customerId, ?string $from = null, ?string $to = null, ?string $status = null): array
    {
        $accountIds = array_column($this->accountsFor($customerId), 'account_id');
        $rows = array_filter($this->data['transactions'], function ($t) use ($accountIds, $from, $to, $status) {
            if (! in_array($t['account_id'], $accountIds)) {
                return false;
            }
            if ($from && $t['transfer_date'] < $from . ' 00:00:00') {
                return false;
            }
            if ($to && $t['transfer_date'] > $to . ' 23:59:59') {
                return false;
            }
            if ($status && $status !== 'all' && $t['status'] !== $status) {
                return false;
            }

            return true;
        });
        usort($rows, fn ($a, $b) => strcmp($b['transfer_date'], $a['transfer_date']));

        return $rows;
    }

    public function recentTransactionsFor(int $customerId, int $limit = 5): array
    {
        return array_slice($this->transactionsFor($customerId), 0, $limit);
    }

    public function spendingFor(int $customerId): float
    {
        $accountIds = array_column($this->accountsFor($customerId), 'account_id');
        $sum = 0.0;
        foreach ($this->data['transfers'] as $t) {
            if ($t['from_account_id'] && in_array($t['from_account_id'], $accountIds) && $t['status'] === 'Completed') {
                $sum += $t['amount'];
            }
        }

        return round($sum, 2);
    }

    public function transferById(int $transferId): ?array
    {
        return $this->data['transfers'][$transferId] ?? null;
    }

    public function transferByReference(string $ref): ?array
    {
        foreach ($this->data['transfers'] as $t) {
            if ($t['reference_code'] === $ref) {
                return $t;
            }
        }

        return null;
    }

    /* ---------------- activity ---------------- */

    public function activitiesFor(int $customerId): array
    {
        $rows = array_filter($this->data['activities'], fn ($a) => $a['customer_id'] === $customerId);
        usort($rows, fn ($a, $b) => strcmp($b['date'], $a['date']));

        return $rows;
    }

    public function unreadActivityCount(int $customerId): int
    {
        return count(array_filter($this->data['activities'], fn ($a) => $a['customer_id'] === $customerId && ! $a['read']));
    }

    public function markActivitiesRead(int $customerId): void
    {
        foreach ($this->data['activities'] as $id => $a) {
            if ($a['customer_id'] === $customerId) {
                $this->data['activities'][$id]['read'] = true;
            }
        }
        $this->persist();
    }

    public function logActivity(int $customerId, string $title, string $body, string $icon = 'transfer'): void
    {
        $id = $this->nextId('activity');
        $this->data['activities'][$id] = [
            'activity_id' => $id,
            'customer_id' => $customerId,
            'title' => $title,
            'body' => $body,
            'icon' => $icon,
            'date' => now()->format('Y-m-d H:i:s'),
            'read' => false,
        ];
        $this->persist();
    }

    /* ---------------- helpers ---------------- */

    public function makeReference(): string
    {
        return sprintf('TRX-%s-%s', now()->format('ymdHis'), strtoupper(substr(bin2hex(random_bytes(2)), 0, 3)));
    }

    public function money(float $amount, string $currency = 'USD'): string
    {
        $symbol = $currency === 'KHR' ? '៛' : '$';

        return $symbol . number_format(abs($amount), 2);
    }
}