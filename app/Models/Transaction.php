<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    protected $fillable = [
        "reference_number",
        "processing_fee",
        "sub_amount",
        "discount",
        "total_amount",
        "payment_method",
        "status",
    ];
}
