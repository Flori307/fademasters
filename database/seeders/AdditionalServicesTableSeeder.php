<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class AdditionalServicesTableSeeder extends Seeder
{
    public function run()
    {
        $additionalServices = [
            [
                'name' => 'Камуфляж седины',
                'slug' => 'kamufliag-sediny',
                'description' => 'Маскировка седины специальными средствами. Естественный вид на 2-3 недели.',
                'duration_minutes' => 45,
                'price' => 2500,
                'category' => 'Окрашивание',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Королевское бритьё',
                'slug' => 'korolevskoe-brite',
                'description' => 'Ритуал бритья опасной бритвой с горячими компрессами и уходом за кожей.',
                'duration_minutes' => 50,
                'price' => 2000,
                'category' => 'Бритьё',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Уход за кожей головы',
                'slug' => 'uhod-za-kozhey-golovy',
                'description' => 'Диагностика, пилинг и увлажнение кожи головы.',
                'duration_minutes' => 35,
                'price' => 1800,
                'category' => 'Уход',
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Стрижка + тонирование',
                'slug' => 'strizhka-tonirovanie',
                'description' => 'Стрижка и лёгкое тонирование волос для придания объёма и текстуры.',
                'duration_minutes' => 80,
                'price' => 3500,
                'category' => 'Окрашивание',
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'name' => 'Экспресс-укладка',
                'slug' => 'express-ukladka',
                'description' => 'Быстрая укладка со средствами стайлинга.',
                'duration_minutes' => 20,
                'price' => 800,
                'category' => 'Укладка',
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'name' => 'Вощение носа и ушей',
                'slug' => 'wosk-nos-ushi',
                'description' => 'Гигиеническая процедура удаления волос в носу и ушах воском.',
                'duration_minutes' => 15,
                'price' => 500,
                'category' => 'Гигиена',
                'is_active' => true,
                'sort_order' => 15,
            ],
        ];

        foreach ($additionalServices as $service) {
            // Проверяем, существует ли уже услуга с таким названием
            if (!Service::where('name', $service['name'])->exists()) {
                Service::create($service);
            }
        }
    }
}