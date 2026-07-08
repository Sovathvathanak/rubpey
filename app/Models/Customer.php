<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'tb_customers';

    protected $primaryKey = 'customer_id';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'Image',
        'password',
        'pin_number',
        'national_id',
        'nationality',
        'phone',
        'email',
        'address',
        'data_of_birth',
        'last_login',
        'created_at',
    ];

    protected $hidden = [
        'password',
        'pin_number',
    ];

    protected function casts(): array
    {
        return [
            'data_of_birth' => 'date',
            'last_login' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'customer_id', 'customer_id');
    }
}
