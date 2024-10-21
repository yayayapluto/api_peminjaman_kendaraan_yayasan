<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_record",
        "id_user",
        "id_vehicle",
        "driver_name",
        "service",
        "image",
        "from_address",
        "from_lon",
        "from_lat",
        "to_address",
        "to_lon",
        "to_lat",
        "status",
        "created_by",
        "updated_by",
        "deleted_by"
    ];
}
