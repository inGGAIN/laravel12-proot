<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberikan izin simpan data
    protected $fillable = [
        'user_id',
        'destination_id',
        'status',
        'booking_date',
        'quantity',
        'total_price',
    ];

    /**
     * Relasi ke User (Satu transaksi dimiliki oleh satu user)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
