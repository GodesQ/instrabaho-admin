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
        "status"
    ];

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }
}
