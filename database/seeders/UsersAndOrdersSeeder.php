<?php
// database/seeders/UsersAndOrdersSeeder.php

namespace Database\Seeders;

use App\Enum\User\UserRoleEnum;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAndOrdersSeeder extends Seeder
{
    public function run()
    {
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'], // Уникальный идентификатор (email)
            [
                'name' => 'Seller User',
                'password' => Hash::make('password'), // Защищенный пароль
                'role' => UserRoleEnum::SELLER,
                'image_url' => '/avatars/default.png',
                'balance' => 1000.00, // Примерный баланс
                'referral_id' => null,
            ]
        );

        // Проверка и создание CUSTOMER
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'], // Уникальный идентификатор (email)
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => UserRoleEnum::CUSTOMER,
                'image_url' => '/avatars/default.png',
                'balance' => 50.00,
                'referral_id' => null,
            ]
        );

        // Создание 10 заказов для CUSTOMER
        $orderTitles = [
            'Разработка лендинга',
            'Создание интернет-магазина',
            'Дизайн логотипа',
            'Создание корпоративного сайта',
            'SEO оптимизация сайта',
            'Разработка мобильного приложения',
            'Интернет-маркетинг',
            'Аудит сайта',
            'Разработка блога',
            'Модернизация веб-приложения',
        ];

        $orderDescriptions = [
            'Необходимо разработать сайт для продажи товаров с функционалом корзины, интеграцией с платёжными системами.',
            'Разработка интернет-магазина с функционалом авторизации, каталогом товаров и системой фильтров.',
            'Дизайн уникального логотипа для нового бренда в сфере e-commerce.',
            'Создание сайта-визитки для крупной компании, с возможностью добавления блоговых записей.',
            'SEO оптимизация сайта для улучшения позиций в поисковых системах и увеличения органического трафика.',
            'Разработка мобильного приложения для Android и iOS с интеграцией с веб-сайтом компании.',
            'Разработка стратегии интернет-маркетинга для привлечения трафика и повышения конверсии.',
            'Аудит текущего сайта для выявления проблем с UX/UI и производительностью.',
            'Создание блога с возможностью добавления статей, комментирования и публикации новостей.',
            'Модернизация веб-приложения с добавлением нового функционала и улучшением интерфейса.',
        ];

        for ($i = 0; $i < 10; $i++) {
            Order::create([
                'seller_id' => $seller->id,
                'customer_id' => $customer->id,
                'price' => rand(500, 3000),
                'commission_price' => rand(50, 300),
                'title' => $orderTitles[$i],
                'description' => $orderDescriptions[$i],
                'count_days' => rand(7, 30),
                'status' => 'NEW',
            ]);
        }

    }
}
