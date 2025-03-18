<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiConsumer extends Model
{
    protected $table = "api_consumers";
    protected $fillable = [
        "app_name",
        "api_key",
        "contact_email",
        "contact_number",
        "status",
        "created_by",
        "updated_by",
    ];
}
