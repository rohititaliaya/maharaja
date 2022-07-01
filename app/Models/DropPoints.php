<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropPoints extends Model
{
    use HasFactory;

    public function getDropPointsAttribute($value)
    {
        return json_decode($value);
    }
}
