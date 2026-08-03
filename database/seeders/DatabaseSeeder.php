<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan HANYA kelima file migration secara spesifik
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--path' => [
                'database/migrations/2026_08_03_044546_create_kuisioner_table.php',
                'database/migrations/2026_08_03_044736_create_pertanyaan_table.php',
                'database/migrations/2026_08_03_044849_create_kuisioner_cabang_table.php',
                'database/migrations/2026_08_03_045001_create_kuisioner_jawaban_table.php',
                'database/migrations/2026_08_03_045041_create_kuisioner_jawaban_item_table.php'
            ]
        ]);

    }
}
