<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";

    protected $fillable = [
        "user_id",
        "country_code",
        "contact_number",
        "address",
        "latitude",
        "longitude",
        "facebook_url"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
