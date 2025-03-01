<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
    protected $table = "services";

    protected $fillable = [
        "category_id",
        "title",
        "description",
    ];
}
