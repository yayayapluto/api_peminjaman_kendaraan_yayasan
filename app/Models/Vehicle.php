<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_vehicle",
        "brand",
        "model",
        "color",
        "nopol",
        "is_available",
        "created_by",
        "updated_by",
        "deleted_by"
    ];
}
