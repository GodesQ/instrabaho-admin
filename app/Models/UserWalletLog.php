<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletLog extends Model
{
    protected $table = "user_wallet_logs";

    protected $fillable = [
        "user_id",
        "user_wallet_id",
        "transer_type",
        "amount",
        "metadata",
        "deposit_at",
        "withdraw_at"
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'double',
            'metadata' => 'array',
            'deposit_at' => 'datetime',
            'withdraw_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_wallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }
}
