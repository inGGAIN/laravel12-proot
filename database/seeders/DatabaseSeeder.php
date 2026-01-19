<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Candi Borobudur',
                'description' => 'Candi Buddha terbesar di dunia yang merupakan warisan budaya UNESCO.',
                'location' => 'Magelang, Jawa Tengah',
                'price' => 50000,
                'image' => 'borobudur.jpg',
            ],
            [
                'name' => 'Pantai Kuta',
                'description' => 'Pantai paling populer di Bali dengan pemandangan matahari terbenam yang ikonik.',
                'location' => 'Badung, Bali',
                'price' => 25000,
                'image' => 'kuta.jpg',
            ],
            [
                'name' => 'Gunung Bromo',
                'description' => 'Gunung berapi aktif dengan kawah yang menakjubkan dan pemandangan sunrise terbaik.',
                'location' => 'Probolinggo, Jawa Timur',
                'price' => 75000,
                'image' => 'bromo.jpg',
            ],
            [
                'name' => 'Raja Ampat',
                'description' => 'Surga bawah laut dengan keanekaragaman hayati laut tertinggi di dunia.',
                'location' => 'Papua Barat',
                'price' => 500000,
                'image' => 'raja_ampat.jpg',
            ],
            [
                'name' => 'Danau Toba',
                'description' => 'Danau vulkanik terbesar di dunia dengan Pulau Samosir di tengahnya.',
                'location' => 'Sumatera Utara',
                'price' => 30000,
                'image' => 'toba.jpg',
            ],
        ];

        foreach ($data as $item) {
            Destination::create($item);
        }
    }
}
