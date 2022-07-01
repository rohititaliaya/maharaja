<?php

namespace App\Models;

use App\Models\City;
use App\Models\Bus;
use App\Models\DatePrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    use HasFactory;

    public function getDefaultPriceAttribute($value)
    {
        return json_decode($value);
    }

    public function getFromAttribute($value)
    {
        $city = City::find($value);
        return ['city_id'=>$value,'city_name'=>$city->name];
    }

    public function getToAttribute($value)
    {
        $city = City::find($value);
        return ['city_id'=>$value,'city_name'=>$city->name];
    }

    public function busname(Type $var = null)
    {
        return $this->hasOne(Bus::class, 'id', 'bus_id');
    }

    public function date_prices(Type $var = null)
    {
        return $this->hasMany(DatePrice::class, 'route_id', 'id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'id');
    }
    public function to()
    {
        return $this->belongsTo(City::class, 'to', 'id');
    }
    public function from()
    {
        return $this->belongsTo(City::class, 'from', 'id');
    }
}
