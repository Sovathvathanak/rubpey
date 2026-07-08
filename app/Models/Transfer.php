<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    protected $table = 'tb_transfers';

    protected $primaryKey = 'transfer_id';

    public $timestamps = false;

    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'amount',
        'reference_code',
        'transfer_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transfer_date' => 'datetime',
        ];
    }

    public function fromAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id', 'account_id');
    }

    public function toAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id', 'account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionHistory::class, 'transfer_id', 'transfer_id');
    }
}
