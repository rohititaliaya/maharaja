<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatePrice extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'route_id', 'id');
    }
}
