<?php

namespace App\Http\Controllers;

use App\Models\Canceled;
use App\Models\Schedule;
use Illuminate\Http\Request;

class CanceledsSchedule extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'description' => 'required|min:4|max:100|string'
        ]);

        $schedule = Schedule::find($request->id);
        
        if ($schedule) {
            $schedule->update([
                'status' => 'cancelado'
            ]);
        }

        Canceled::query()->create([
            'description' => $request->description,
            'user_id'     => auth()->user()->id,
            'schedule_id' => $schedule->id,
        ]);

        return redirect()
                ->route('schedules.mySchedules')
                ->with('success', 'Agendamento cancelado!');
    }
}
