<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Routes;
use App\Models\PickupPoints;
use App\Models\DropPoints;
use App\Models\ConfirmedSeat    ;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
    "bus_name",
    "no_plate",
    "agent_id",
    "price",
    "drop_point",
    "pickup_point",
    "pickup_time",
    "drop_time",
    "total_time",
    "status"];

    public function routes()
    {
        return $this->hasOne(Routes::class, 'bus_id', 'id');
    }

    public function cseat()
    {
        return $this->hasMany(ConfirmedSeat::class, 'bus_id', 'id');
    }

    public function last_pick()
    {
        return $this->hasMany(PickupPoints::class, 'bus_id', 'id');
    }

    public function last_drop()
    {
        return $this->hasMany(DropPoints::class, 'bus_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id' , 'id');
    }
}
