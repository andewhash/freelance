<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Очищаем таблицу перед заполнением
        $countries = [
            ['name' => 'Узбекистан', 'code' => 'UZ'],
            ['name' => 'Киргизия', 'code' => 'KG'],
            ['name' => 'Китай', 'code' => 'CN'],
            ['name' => 'Россия', 'code' => 'RU'],
            ['name' => 'Белоруссия', 'code' => 'BY'],
            ['name' => 'Турция', 'code' => 'TR'],
            ['name' => 'Казахстан', 'code' => 'KZ'],
        ];

        foreach ($countries as $country) {
            Country::create([
                'name' => $country['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Страны успешно добавлены!');
    }
}