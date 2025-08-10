<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\AdPosition;
class AdPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Позиции для поиска
        for ($i = 1; $i <= 10; $i++) {
            AdPosition::create([
                'type' => 'search',
                'position' => $i,
                'current_bid' => $i * 100,
                'current_user_id' => null
            ]);
        }

        // Позиции для каталога
        for ($i = 1; $i <= 10; $i++) {
            AdPosition::create([
                'type' => 'catalog',
                'position' => $i,
                'current_bid' => $i * 50,
                'current_user_id' => null
            ]);
        }
    }
}
