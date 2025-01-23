<?php

// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Проверка и создание ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Уникальный идентификатор (email)
            [
                'name' => 'Admin User',
                'password' => Hash::make('adminpassword'), // Защищенный пароль
                'role' => 'ADMIN',
                'image_url' => '/avatars/admin.png', // Можно использовать иконку или изображение для администратора
                'balance' => 0, // Баланс для администратора
                'referral_id' => null,
            ]
        );

    }
}
