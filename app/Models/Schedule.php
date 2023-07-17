<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'day_of_week',
        'month_of_year',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canceleds()
    {
        return $this->hasMany(Canceled::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $carbon = Carbon::parse($value);
                $date = $carbon->format('d/m/Y');
                $hour = $carbon->format('H:i');
               
                return "Agendado por você em {$date} às {$hour}";
            }   
        );
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y')     
        );
    }

    protected function dayOfWeek(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $carbon = Carbon::parse($value);
                $carbon->locale('pt_BR');
                $nameDayWeek = $carbon->isoFormat('dddd');
               
                return $nameDayWeek;
            }
        );
    }

    protected function monthOfYear(): Attribute
    {
        return Attribute::make(
            get: function () {
                $date = Carbon::createFromFormat('d/m/Y', $this->date);
                $day = $date->format('d');
                $month = strtoupper($date->shortEnglishMonth);
                $year = $date->format('Y');

                return "{$day}/{$month}/{$year}";
            }
        );
    }

    public function haveScheduling(): bool
    {
        return $this->query()
                    ->where('status', '=', 'pendente')
                    ->where('user_id', '=', auth()->user()->id)
                    ->exists();
    }
    
    public function hoursAvailable(array $datasEnums, string $data)
    {
        $busy = $this->whereDate('date', '=', $data)
            ->get(['hour', 'barber'])
            ->toArray();
    
        if ($data > now()->format('Y-m-d')) {
            $newHours = $this->hoursAvailableFuture($datasEnums, $busy);
        } else {
            $newHours = $this->hoursAvailableToday($datasEnums, $busy);
        }
    
        return $newHours;
    }
    
    protected function hoursAvailableFuture(array $datasEnums, array $busy)
    {
        $newHours = [];
    
        foreach ($datasEnums as $case) {
            $resultHours = $case->value;
    
            $isBusyForBarber1 = false;
            $isBusyForBarber2 = false;
    
            foreach ($busy as $busyTime) {
                if ($busyTime['hour'] == $resultHours && $busyTime['barber'] == '1') {
                    $isBusyForBarber1 = true;
                }
    
                if ($busyTime['hour'] == $resultHours && $busyTime['barber'] == '4') {
                    $isBusyForBarber2 = true;
                }
            }
    
            if (!($isBusyForBarber1 && $isBusyForBarber2)) {
                $newHours[] = $case;
            }
        }

        return $newHours;
    }
    

    
    protected function hoursAvailableToday(array $datasEnums, array $busy)
    {
        $selectedHour = now()->format('H:i');
        
        $availableTimes = collect($datasEnums)->filter(function ($case) use ($selectedHour) {
            return $case->value > $selectedHour;
        })->values()->toArray();
    
        $newHours = [];
    
        foreach ($availableTimes as $case) {
            $resultHours = $case->value;
            $barberName = $case->name;
    
            $isBusy = false;
            foreach ($busy as $busyTime) {
                if ($busyTime['hour'] == $resultHours && in_array($busyTime['barber'], [1, 4])) {
                    $isBusy = true;
                    break;
                }
            }
    
            if (!$isBusy || $resultHours == $selectedHour) {
                $newHours[] = $resultHours;
            }
        }
    
        return $newHours;
    }
    

    public function getSchedules(?string $status, ?string $date)
    {
        $query = $this
                ->when(str($date)->isNotEmpty(), fn($query) => $query->where('date', '=', Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d')))
                ->when($status == 'pendente' || $status == null, fn($query) => $query->where('status', '=', 'pendente'))
                ->when($status == 'finalizado', fn($query) => $query->where('status', '=', 'finalizado'))
                ->when($status == 'cancelado', fn($query) => $query->where('status', '=', 'cancelado'))
                ->select('*', 
                    DB::raw('(SELECT description FROM canceleds WHERE canceleds.schedule_id = schedules.id) AS cancellation_reason')
                )
                ->with('user:id,name,image')
                ->orderBy('date', 'ASC');

        return $query->paginate(8);
    }

    public function countSchedules(): Object
    {
        return $this->select(
            DB::raw('(SELECT COUNT(*) FROM schedules WHERE status = "pendente") AS count_pending'),
            DB::raw('(SELECT COUNT(*) FROM schedules WHERE status = "finalizado") AS count_finished'),
            DB::raw('(SELECT COUNT(*) FROM schedules WHERE status = "cancelado") AS count_canceleds'),
        )->first();
    }

    public function getMySchedules(): LengthAwarePaginator
    {
        return $this->leftJoin('canceleds', 'schedules.id', '=', 'canceleds.schedule_id')
                    ->select('schedules.*', 'canceleds.description', 'canceleds.user_id AS author_canceled_id')
                    ->where('schedules.user_id', auth()->user()->id)
                    ->paginate(3);   
    }

    
      



}
