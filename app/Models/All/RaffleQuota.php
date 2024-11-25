<?php

namespace App\Models\All;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleQuota extends Model
{
    /** @use HasFactory<\Database\Factories\All\RaffleQuotaFactory> */
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'quota_number',
        'status',
        'user_id',
    ];

    /**
     * Relacionamento: Cota pertence a uma Rifa.
     */
    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    /**
     * Relacionamento: Cota pertence a um usuário (se comprada ou reservada).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Escopo para cotas disponíveis.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Escopo para cotas reservadas.
     */
    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    /**
     * Escopo para cotas vendidas.
     */
    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }
}
