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
        $user = auth()->user();

        if ($schedule) {
            $schedule->update([
                'status' => 'cancelado'
            ]);
        }

        Canceled::query()->create([
            'description' => $request->description,
            'user_id'     => $user->id,
            'schedule_id' => $schedule->id,
        ]);
        
        $route = $user->type == 'manager' ? 'schedules.index' : 'schedules.mySchedules';

        return redirect()
                ->route($route)
                ->with('success', 'Agendamento cancelado!');
    }
}
