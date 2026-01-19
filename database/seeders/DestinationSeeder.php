<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
            [
                'name' => 'Candi Borobudur',
                'description' => 'Candi Buddha terbesar di dunia.',
                'location' => 'Magelang, Jawa Tengah',
                'price' => 50000,
                'image' => 'borobudur.jpg',
            ],
            // ... data lainnya
        ];

        foreach ($data as $item) {
            Destination::create($item); // Sekarang PHP tahu Destination adalah Model
        }
    }
}
