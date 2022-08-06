<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'book_id',
        'user_id',
        'transaction_id',
        'status',
        'payment_status',
        'total_amount',
        'amount_without_tax',
        'transfered_amount',
        'refunded_amount',
        'agent_id',
        'transfer_id',
        'transfer_on_hold',
        'transfer_hold_till',
        'refund_obj'
    ];

    public function book()
    {
        return $this->belongsTo(ConfirmedSeat::class, 'book_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','id');
    }
}
