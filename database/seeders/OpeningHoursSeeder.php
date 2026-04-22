<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use Illuminate\Database\Seeder;

class OpeningHoursSeeder extends Seeder
{
    public function run(): void
    {
        OpeningHour::truncate();

        $schedule = [
            0 => [['07:00', '13:15'], ['17:30', '20:00']],
            1 => [['07:00', '13:15'], ['17:30', '20:00']],
            2 => [['07:00', '13:15']],
            3 => [['07:00', '13:15'], ['17:30', '20:00']],
            4 => [['07:00', '13:15'], ['17:30', '20:00']],
            5 => [['07:00', '13:15'], ['17:30', '20:00']],
        ];

        foreach ($schedule as $day => $slots) {
            foreach ($slots as $i => [$open, $close]) {
                OpeningHour::create([
                    'day_of_week' => $day,
                    'opens_at' => $open,
                    'closes_at' => $close,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
