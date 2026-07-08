<?php

use App\Services\MockBank;

it('completes the full register wizard and lands on dashboard', function () {
    $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test.user@example.com',
        'phone' => '+855 11 222 333',
        'data_of_birth' => '2000-01-01',
        'address' => 'Phnom Penh',
    ])->assertRedirect(route('register.step2'));

    $this->post('/register/verification', [
        'national_id' => '999888777',
        'nationality' => 'Cambodia',
    ])->assertRedirect(route('register.step3'));

    $this->post('/register/security', [
        'pin' => '135790',
        'pin_confirmation' => '135790',
        'terms' => '1',
    ])->assertRedirect(route('register.complete'));

    $this->get('/register/complete')->assertOk()->assertSee('Account Created!');

    $this->post('/register/finish')->assertRedirect(route('dashboard'));
    $this->get('/dashboard')->assertOk()->assertSee('Welcome back, Test User');
});

it('signs in a seeded customer with national id and PIN', function () {
    $this->get('/login')->assertOk();

    $this->post('/login', ['national_id' => '001122334', 'pin' => '123456'])
        ->assertRedirect(route('dashboard'));

    $this->get('/dashboard')->assertOk()->assertSee('Welcome back, Layhout Tang');
});

it('rejects a wrong PIN', function () {
    $this->post('/login', ['national_id' => '001122334', 'pin' => '000000'])
        ->assertSessionHasErrors('national_id');
});

it('opens a new account starting at zero and deposits into it', function () {
    login($this);

    $this->post('/accounts', [
        'account_name' => 'Vacation Fund',
        'account_type' => 'Savings',
        'currency' => 'USD',
    ])->assertRedirectContains('/created');

    $bank = app(MockBank::class);
    $account = collect($bank->accountsFor(1))->firstWhere('account_name', 'Vacation Fund');
    expect($account['balance'])->toBe(0.0)
        ->and($account['status'])->toBe('Active');

    // deposit 250 into it
    $this->post('/deposit/review', ['account_id' => $account['account_id'], 'amount' => 250])
        ->assertOk()
        ->assertSee('Confirm Your Deposit');

    $this->post('/deposit/confirm')->assertRedirect(route('deposit.success'));
    $this->get('/deposit/success')->assertOk()->assertSee('Deposit Successful');

    $account = app(MockBank::class)->account($account['account_id']);
    expect($account['balance'])->toBe(250.0);
});

it('transfers money between customers with PIN confirmation', function () {
    login($this);

    // Layhout's Main Savings (id 1, $12,450) -> Kimkuy's 001-2000001 ($8,750)
    $this->post('/transfers/source', ['source_account_id' => 1])->assertRedirect(route('transfers.details'));

    $this->post('/transfers/details', [
        'recipient_account_number' => '001-2000001',
        'amount' => 450,
        'remark' => 'Lunch money',
    ])->assertRedirect(route('transfers.review'));

    $this->get('/transfers/review')->assertOk()->assertSee('Kimkuy Ngo');

    $this->post('/transfers/confirm', ['pin' => '123456'])->assertRedirect(route('transfers.success'));
    $this->get('/transfers/success')->assertOk()->assertSee('Transfer Completed Successfully');

    $bank = app(MockBank::class);
    expect($bank->account(1)['balance'])->toBe(12000.0)
        ->and($bank->account(3)['balance'])->toBe(9200.0);

    // both sides got matching transaction rows
    $senderTx = collect($bank->transactionsFor(1))->firstWhere('amount', -450.0);
    $recipientTx = collect($bank->transactionsFor(2))->firstWhere('amount', 450.0);
    expect($senderTx)->not->toBeNull()
        ->and($recipientTx)->not->toBeNull()
        ->and($senderTx['transfer_id'])->toBe($recipientTx['transfer_id']);
});

it('fails a transfer with insufficient funds and does not change balances', function () {
    login($this);

    $this->post('/transfers/source', ['source_account_id' => 2]); // Daily Checking $3,200.50
    $this->post('/transfers/details', [
        'recipient_account_number' => '001-2000001',
        'amount' => 999999,
    ]);
    $this->post('/transfers/confirm', ['pin' => '123456'])->assertRedirect(route('transfers.failed'));
    $this->get('/transfers/failed')->assertOk()->assertSee('Transfer Could Not Be Processed');

    $bank = app(MockBank::class);
    expect($bank->account(2)['balance'])->toBe(3200.50)
        ->and($bank->account(3)['balance'])->toBe(8750.0);
});

it('rejects a transfer with a wrong PIN', function () {
    login($this);

    $this->post('/transfers/source', ['source_account_id' => 1]);
    $this->post('/transfers/details', [
        'recipient_account_number' => '001-2000001',
        'amount' => 10,
    ]);
    $this->post('/transfers/confirm', ['pin' => '999999'])->assertSessionHasErrors('pin');

    expect(app(MockBank::class)->account(1)['balance'])->toBe(12450.0);
});

it('blocks access to another customer\'s account detail', function () {
    login($this);

    // account 3 belongs to Kimkuy (customer 2)
    $this->get('/accounts/3')->assertNotFound();
});

it('guards every app route behind login', function () {
    foreach (['/dashboard', '/accounts', '/transfers', '/deposit', '/transactions', '/activity', '/profile', '/settings'] as $path) {
        $this->get($path)->assertRedirect(route('login'));
    }
});

it('updates the profile from settings', function () {
    login($this);

    $this->post('/settings', [
        'first_name' => 'Layhout',
        'last_name' => 'Tang',
        'email' => 'new.email@example.com',
        'phone' => '+855 12 662 933',
    ])->assertRedirect(route('settings.index'));

    expect(app(MockBank::class)->customer(1)['email'])->toBe('new.email@example.com');
});

it('resets a PIN via identity verification', function () {
    $this->post('/forgot-pin', ['national_id' => '001122334', 'phone' => '+855 12 662 933'])
        ->assertRedirect(route('password.reset'));

    $this->post('/reset-pin', ['pin' => '654321', 'pin_confirmation' => '654321'])
        ->assertRedirect(route('login'));

    $this->post('/login', ['national_id' => '001122334', 'pin' => '654321'])
        ->assertRedirect(route('dashboard'));
});

function login($test): void
{
    $test->post('/login', ['national_id' => '001122334', 'pin' => '123456']);
}
