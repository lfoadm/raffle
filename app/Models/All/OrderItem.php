<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}
