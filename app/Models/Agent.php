<?php

namespace App\Models;
use App\Models\Bus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public function buses()
    {
        return $this->hasMany(Bus::class, 'agent_id', 'id');
    }
}
