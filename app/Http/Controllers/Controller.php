<?php

namespace App\Http\Controllers;

use App\Services\MockBank;

abstract class Controller
{
    protected function bank(): MockBank
    {
        return app(MockBank::class);
    }

    protected function customerId(): int
    {
        return (int) session('customer_id');
    }

    protected function customer(): array
    {
        return $this->bank()->customer($this->customerId());
    }

    /** Shared view data for the app shell (topbar unread dot). */
    protected function shell(array $data = []): array
    {
        return $data + [
            'customer' => $this->customer(),
            'unreadActivity' => $this->bank()->unreadActivityCount($this->customerId()),
        ];
    }
}
