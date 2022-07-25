<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'agent_id',
        'account_number',
        'banificary_name',
        'ifsc_code',
        'bank_name',
        'city_name'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id' , 'id');
    }
}
