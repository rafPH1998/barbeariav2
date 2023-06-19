<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            get: function ($value) {
                $date = Carbon::parse($value);
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
        $ocupados = $this->whereDate('date', '=', $data)
                        ->pluck('hour')
                        ->toArray();

        if ($data > now()->format('Y-m-d')) {
            $novosHorarios = $this->hoursAvailableFuture($datasEnums, $ocupados);
        } else {
            $novosHorarios = $this->hoursAvailableToday($datasEnums, $ocupados);
        }
                
        return $novosHorarios;
    }

    protected function hoursAvailableFuture(array $datasEnums, array $ocupados)
    {
        $novosHorarios = [];
    
        foreach ($datasEnums as $case) {
            $valor = $case->value;
            if (!in_array($valor, $ocupados)) {
                $novosHorarios[] = $valor;
            }
        }
    
        return $novosHorarios;
    }
    
    protected function hoursAvailableToday(array $datasEnums, array $ocupados)
    {
        $horariosDisponiveis = collect($datasEnums)->filter(function ($hora) {
            return $hora->value > now()->format('H:i');
        })->values()->toArray();
    
        $novosHorarios = [];
    
        foreach ($horariosDisponiveis as $case) {
            $valor = $case->value;
            if (!in_array($valor, $ocupados)) {
                $novosHorarios[] = $valor;
            }
        }
    
        return $novosHorarios;
    }
}
