<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobContractWallet extends Model
{
    protected $table = "job_contract_wallets";

    protected $fillable = [
        "contract_id",
        "amount",
        "withdraw_amount",
        "contract_withdraw_at",
    ];
}
