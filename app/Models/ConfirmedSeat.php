<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmedSeat extends Model
{
    use HasFactory;

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'id');
    }

    public function getFromAttribute($value)
    {
        $city = City::find($value);
        return $city->name;
    }

    public function getToAttribute($value)
    {
        $city = City::find($value);
        return $city->name;
    }
}
