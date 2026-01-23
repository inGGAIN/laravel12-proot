<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
