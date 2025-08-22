<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class DatabaseSeeder extends Seeder
{
    private $totalCompanies = 2281;
    private $limit = 12;
    private $apiUrl = 'https://api.textilefinds.com/api/v1/companies';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Очищаем таблицу перед заполнением
        DB::table('categories')->truncate();

        // Получаем категории из API
        $response = Http::get('https://api.textilefinds.com/api/v1/categories');

        if ($response->successful()) {
            $categories = $response->json();

            
                        // Обрабатываем каждую категорию
            foreach ($categories['items'] as $category) {
                $this->saveCategoryWithChildren($category);
            }

            $this->command->info('Categories seeded successfully!');
        } else {
            $this->command->error('Failed to fetch categories from API.');
        }




         // Очищаем таблицы перед заполнением
        //  DB::table('users')->truncate();
        //  DB::table('user_categories')->truncate();
 
        //  $totalPages = ceil($this->totalCompanies / $this->limit);
 
        //  for ($offset = 0; $offset < $this->totalCompanies; $offset += $this->limit) {
        //      $url = $this->apiUrl . "?limit={$this->limit}&offset={$offset}&category_ids=0&country_ids=0&certificate_ids=0";
             
        //      $response = Http::get($url);
 
        //      if ($response->successful()) {
        //          $data = $response->json();
                 
        //          if (isset($data['items'])) {
        //              foreach ($data['items'] as $company) {
        //                  $this->saveCompany($company);
        //              }
        //          }
 
        //          $this->command->info("Processed {$offset}/{$this->totalCompanies} companies");
        //      } else {
        //          $this->command->error("Failed to fetch companies. Offset: {$offset}");
        //          Log::error('Failed to fetch companies', [
        //              'offset' => $offset,
        //              'response' => $response->body()
        //          ]);
        //      }
        //  }
 
         $this->command->info('All companies seeded successfully!');
    }

    /**
     * Сохраняет категорию и ее дочерние элементы
     *
     * @param array $category
     * @param int|null $parentId
     */
    private function saveCategoryWithChildren(array $category, ?int $parentId = null)
    {
        // Сохраняем текущую категорию
        DB::table('categories')->updateOrInsert(
            ['id' => $category['id']],
            [
                'name' => $category['name'],
                'parent_id' => $parentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Если есть дочерние категории, обрабатываем их рекурсивно
        if (!empty($category['children'])) {
            foreach ($category['children'] as $child) {
                $this->saveCategoryWithChildren($child, $category['id']);
            }
        }
    }


    private function saveCompany(array $company)
    {
        // Генерируем случайный пароль для пользователя
        $password = Str::random(12);

        // Сохраняем основную информацию о компании
        $userId = DB::table('users')->insertGetId([
            'name' => $company['name'] ?? null,
            'brand' => $company['brand'] ?? null,
            'contact_email' => $company['contacts']['email'] ?? Str::random(10).'@example.com',
            'business_type' => $company['business_type'] ?? null,
            'rating' => $company['rating'] ?? 0,
            'exported' => $company['is_exporter'] ?? false,
            'count_employers' => $company['employee_count'] ?? '0',
            'year' => $company['foundation_date'] ?? '0',
            'status' => 'member',
            'password' => bcrypt($password),
            'description' => $company['text'] ?? null,
            'address' => $company['address'] ?? null,
            'telegram' => $company['contacts']['telegram'] ?? null,
            'phone' => $company['contacts']['phone'] ?? null,
            'site' => $company['contacts']['website'] ?? null,
            'country' => $company['country']['name'] ?? null,
            'whatsapp' => $company['contacts']['whatsapp'] ?? null,
            'mark' => $company['annual_turnover'] ?? null,
            'role' => 'company',
            'image_url' => $company['image']['file_src'] ?? '/avatars/default.png',
            'balance' => 0,
            'referral_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Сохраняем категории пользователя
        if (!empty($company['category_ids'])) {
            foreach ($company['category_ids'] as $categoryId) {
                DB::table('user_categories')->insert([
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
