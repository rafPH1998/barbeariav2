<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
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
