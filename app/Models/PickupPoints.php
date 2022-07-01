<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;
class PickupPoints extends Model
{
    use HasFactory;

    public function getPickupPointsAttribute($value)
    {
        return json_decode($value);
    }   
}
