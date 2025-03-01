<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerPersonalDocument extends Model
{
    protected $table = "worker_personal_docuements";
    protected $fillable = [
        "worker_id",
        "document_filename",
        "status",
    ];
}
