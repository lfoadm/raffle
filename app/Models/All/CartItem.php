<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}