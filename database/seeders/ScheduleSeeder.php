<?php

namespace Database\Seeders;

use App\Enums\AvailableTimeEnum;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::take(20)->get();
        $availableTimes = AvailableTimeEnum::cases();

        foreach ($users as $user) {
            $date = now()->addDays(rand(1, 7))->toDateString();
            $hour = Arr::random($availableTimes);
            $status = Arr::random(['pendente', 'cancelado', 'finalizado']);
            $service = Arr::random(['corte', 'corte_barba']);

            Schedule::create([
                'user_id' => $user->id,
                'date' => $date,
                'hour' => $hour,
                'end_service' => '20:00',
                'status' => $status,
                'barber' => 1,
                'service' => $service,
            ]);
        }
    }

}
