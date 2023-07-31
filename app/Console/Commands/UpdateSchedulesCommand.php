<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateSchedulesCommand extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $schedules = Schedule::where('status', 'pendente')
                        ->where('date', '=', $now->format('Y-m-d'))
                        ->where('end_service', '<=', $now->format('H:i'))
                        ->get();     

        foreach ($schedules as $schedule) {

            Schedule::where('id', $schedule->id)
                    ->update(['status' => 'finalizado']);
        }   
    }
}
