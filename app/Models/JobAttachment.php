<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAttachment extends Model
{
    protected $table = "job_post_attachments";
    protected $fillable = [
        "job_post_id",
        "attachment_filename"
    ];
}
