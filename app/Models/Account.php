<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $table = 'tb_accounts';

    protected $primaryKey = 'account_id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'account_type',
        'account_number',
        'balance',
        'status',
        'currency',
        'account_name',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function outgoingTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_account_id', 'account_id');
    }

    public function incomingTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_account_id', 'account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionHistory::class, 'account_id', 'account_id');
    }
}
