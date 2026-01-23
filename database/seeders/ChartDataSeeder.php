<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChartDataSeeder extends Seeder
{
    public function run(): void
    {
        // Data jumlah destinasi yang ingin diinput per bulan
        // Format: [Bulan => Jumlah Data]
        $dataPariwisata = [
            1 => 5,  // Januari
            2 => 8,  // Februari
            3 => 12, // Maret
            4 => 7,  // April
            5 => 15, // Mei
            6 => 20, // Juni
            7 => 18, // Juli
            8 => 25, // Agustus
            9 => 30, // September
            10 => 22, // Oktober
            11 => 15, // November
            12 => 10  // Desember
        ];

        foreach ($dataPariwisata as $month => $count) {
            for ($i = 1; $i <= $count; $i++) {
                Destination::create([
                    'name' => "Destinasi Dummy $month-$i",
                    'description' => "Deskripsi indah untuk destinasi di bulan ke-$month.",
                    'location' => "Lokasi Wisata $i",
                    'price' => rand(10000, 100000),
                    'image' => "dummy.jpg", // Pastikan file ini ada atau abaikan jika nullable
                    'created_at' => Carbon::create(2025, $month, rand(1, 28), rand(8, 20), 0, 0),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}