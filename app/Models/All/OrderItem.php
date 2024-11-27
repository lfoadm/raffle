<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'raffle_id',
        'raffle_quota_id',
        'quota_amount',
        'unit_price',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function raffleQuota()
    {
        return $this->belongsTo(RaffleQuota::class, 'raffle_quota_id');
    }

}
