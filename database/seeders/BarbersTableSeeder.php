<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BarbersTableSeeder extends Seeder
{
    public function run()
    {
        $barbers = [
            [
                'name' => 'Артём Волков',
                'email' => 'artem@fademasters.ru',
                'phone' => '+7 (999) 111-22-33',
                'nickname' => 'Артём',
                'specialization' => 'Fade, Моделирование бороды',
                'experience_years' => 8,
                'description' => 'Ведущий мастер барбершопа. Специализируется на фейдах и сложных переходах. Участник чемпионата России по барберингу.',
                'start_time' => '10:00',
                'end_time' => '20:00',
                'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'services' => [1, 2, 3, 5], // Мужская стрижка, Стрижка+борода, Моделирование бороды, Fade
            ],
            [
                'name' => 'Дмитрий Соколов',
                'email' => 'dmitry@fademasters.ru',
                'phone' => '+7 (999) 222-33-44',
                'nickname' => 'Дмитрий',
                'specialization' => 'Борода, Классика',
                'experience_years' => 6,
                'description' => 'Мастер по работе с бородой. Знает всё о мужском уходе и стиле.',
                'start_time' => '10:00',
                'end_time' => '21:00',
                'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'services' => [1, 2, 3], // Мужская стрижка, Стрижка+борода, Моделирование бороды
            ],
            [
                'name' => 'Максим Кузнецов',
                'email' => 'maxim@fademasters.ru',
                'phone' => '+7 (999) 333-44-55',
                'nickname' => 'Максим',
                'specialization' => 'Fade, Стрижки машинкой',
                'experience_years' => 5,
                'description' => 'Молодой и талантливый мастер. Отлично работает с машинкой.',
                'start_time' => '11:00',
                'end_time' => '20:00',
                'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'sunday'],
                'services' => [1, 5], // Мужская стрижка, Fade
            ],
            [
                'name' => 'Анна Морозова',
                'email' => 'anna@fademasters.ru',
                'phone' => '+7 (999) 444-55-66',
                'nickname' => 'Анна',
                'specialization' => 'Детские стрижки, Моделирование',
                'experience_years' => 4,
                'description' => 'Находит подход к маленьким клиентам. Детские стрижки без слёз.',
                'start_time' => '10:00',
                'end_time' => '19:00',
                'working_days' => ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'services' => [1, 4], // Мужская стрижка, Детская стрижка
            ],
            [
                'name' => 'Сергей Павлов',
                'email' => 'sergey@fademasters.ru',
                'phone' => '+7 (999) 555-66-77',
                'nickname' => 'Сергей',
                'specialization' => 'Премиум стрижки, Колористика',
                'experience_years' => 7,
                'description' => 'Работает с элитной косметикой. Делает окрашивание и тонирование.',
                'start_time' => '12:00',
                'end_time' => '22:00',
                'working_days' => ['monday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'services' => [1, 2, 5], // Мужская стрижка, Стрижка+борода, Fade
            ],
        ];

        foreach ($barbers as $barberData) {
            // Создаём пользователя
            $user = User::create([
                'name' => $barberData['name'],
                'email' => $barberData['email'],
                'phone' => $barberData['phone'],
                'password' => bcrypt('password123'),
            ]);
            
            $user->assignRole('barber');
            
            // Создаём профиль барбера
            $services = $barberData['services'];
            unset($barberData['services'], $barberData['name'], $barberData['email'], $barberData['phone']);
            
            $barber = Barber::create(array_merge($barberData, [
                'user_id' => $user->id,
                'is_active' => true,
            ]));
            
            // Привязываем услуги
            $barber->services()->sync($services);
        }
    }
}