<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientReview extends Model
{
    protected $table = "client_reviews";
    protected $fillable = [
        "reviewer_id", //workers
        "client_id",
        "feedback_message",
        "rate",
        "metadata"
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'reviewer_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
