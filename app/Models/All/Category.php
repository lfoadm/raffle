<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\All\CategoryFactory> */
    use HasFactory;

    public function raffles()
    {
        return $this->hasMany(Raffle::class);
    }
}
