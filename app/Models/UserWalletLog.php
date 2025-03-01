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
}
