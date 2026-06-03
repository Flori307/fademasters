<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Barber;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            [
                'barber_nickname' => 'Артём',
                'rating' => 5,
                'comment' => 'Отличный мастер! Сделал идеальный фейд, очень доволен результатом. Обязательно приду ещё.',
                'user_name' => 'Алексей',
            ],
            [
                'barber_nickname' => 'Дмитрий',
                'rating' => 5,
                'comment' => 'Лучший по бороде в городе! Подобрал форму, дал кучу советов по уходу.',
                'user_name' => 'Игорь',
            ],
            [
                'barber_nickname' => 'Максим',
                'rating' => 4,
                'comment' => 'Хороший мастер, быстро и качественно. Немного дороговато, но результат того стоит.',
                'user_name' => 'Денис',
            ],
            [
                'barber_nickname' => 'Анна',
                'rating' => 5,
                'comment' => 'Водим сына только к Анне. Ребёнок не боится, стрижку делает отличную!',
                'user_name' => 'Екатерина',
            ],
            [
                'barber_nickname' => 'Сергей',
                'rating' => 5,
                'comment' => 'Премиум-обслуживание! Очень приятная атмосфера, мастер высшего уровня.',
                'user_name' => 'Михаил',
            ],
        ];

        foreach ($reviews as $reviewData) {
            $barber = Barber::where('nickname', $reviewData['barber_nickname'])->first();
            if ($barber) {
                Review::create([
                    'user_id' => User::where('name', $reviewData['user_name'])->first()?->id ?? User::first()->id,
                    'barber_id' => $barber->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                    'is_approved' => true,
                ]);
            }
        }
    }
}