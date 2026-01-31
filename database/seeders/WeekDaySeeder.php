<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeekDay;

class WeekDaySeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            'شنبه',
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه'
        ];

        foreach ($days as $day) {
            WeekDay::create([
                'name' => $day
            ]);
        }
    }
}
