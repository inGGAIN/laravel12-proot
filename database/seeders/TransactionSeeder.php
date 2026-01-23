<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID yang tersedia
        $destinationIds = Destination::pluck('id');
        $userIds = User::pluck('id');

        if ($destinationIds->isEmpty() || $userIds->isEmpty()) {
            $this->command->info('Pastikan tabel users dan destinations sudah ada datanya!');
            return;
        }

        // Kita buat 20 data bookingan acak untuk bulan ini (Januari 2026)
        for ($i = 0; $i < 20; $i++) {
            $destId = $destinationIds->random();
            $destination = Destination::find($destId);
            $qty = rand(1, 5);
            
            // Mengacak tanggal di bulan Januari 2026
            $randomDate = Carbon::create(2026, 1, rand(1, 24), rand(8, 20), 0, 0);

            Transaction::create([
                'user_id'        => $userIds->random(),
                'destination_id' => $destId,
                'status'         => collect(['pending', 'success', 'cancel'])->random(),
                'quantity'       => $qty,
                'total_price'    => $destination->price * $qty,
                'booking_date'   => $randomDate,
                'created_at'     => $randomDate,
                'updated_at'     => $randomDate,
            ]);
        }

        $this->command->info('Berhasil membuat 20 data bookingan dummy!');
    }
}