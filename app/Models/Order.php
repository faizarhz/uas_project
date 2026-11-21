<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'items'   => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'Lunas',
            'cod'       => 'Bayar di Tempat (COD)',
            'failed'    => 'Pembayaran Gagal',
            'expired'   => 'Kedaluwarsa',
            'cancelled' => 'Dibatalkan',
            'refunded'  => 'Dikembalikan',
            default     => 'Menunggu Pembayaran',
        };
    }
}
