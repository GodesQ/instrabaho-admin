<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $table = "users_wallets";
    protected $fillable = [
        "user_id",
        "balance",
        "deposit_method",
        "withdraw_method",
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'double',
        ];
    }
}
