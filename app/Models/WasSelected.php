<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasSelected extends Model
{
    use HasFactory;

    public function getSelectedSeatsAttribute($value)
    {
        return json_decode($value);
    } 
}
