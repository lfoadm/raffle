<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [];
    
    public function cart()
    {
        return $this->belongsTo(Cart::class);
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
