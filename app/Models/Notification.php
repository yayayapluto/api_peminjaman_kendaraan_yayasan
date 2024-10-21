<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_notification",
        "id_user",
        "id_record",
        "status",
        "message",
        "is_read",
        "created_by",
        "updated_by",
        "deleted_by"
    ];
}
