<?php

namespace App\Services;

use App\Enums\AvailableTimeEnum;
use Carbon\Carbon;

final class CalendarService
{

    public function getAvailableHoursByDate($schedules)
    {
        $schedulesAvailableByDate = [];

        foreach ($schedules as $schedule) {
            $date = $schedule->date;

            if (!isset($schedulesAvailableByDate[$date])) {
                $schedulesAvailableByDate[$date] = AvailableTimeEnum::cases();
            }

            $schedulesAvailableByDate[$date] = array_filter($schedulesAvailableByDate[$date], function ($horario) use ($schedule) {
                return $horario->value !== $schedule->hour;
            });
        }

        return $schedulesAvailableByDate;
    }

    public function filterAvailableHoursByDate($schedulesAvailableByDate)
    {
        $currentDate = Carbon::now()->format('d/m/Y');

        return collect($schedulesAvailableByDate)->map(function ($hours, $date) use ($currentDate) {
            if ($date !== $currentDate) {
                return $hours;
            }

            $currentTime = Carbon::now()->format('H:i');
            return collect($hours)->filter(function ($h) use ($currentTime) {
                return $h->value > $currentTime;
            });
        })->values()->toArray();
    }

}