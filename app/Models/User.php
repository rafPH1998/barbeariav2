<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'birthday',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y')     
        );
    }

    public function agenda(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    public static function getUsersMissing()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3)->format('Y-m-d');
        
        return self::select('id', 'name', 'image', 'created_at')
                    ->withCount('agenda')
                    ->whereNotExists(function ($query) use ($threeMonthsAgo) {
                        $query->select()
                            ->from('schedules')
                            ->whereRaw('schedules.user_id = users.id')
                            ->where('schedules.date', '>=', $threeMonthsAgo);
                    })
                    ->paginate(8);
    }

    public static function getUserBirthdayData()
    {
        $dateCarbon = Carbon::now();
        $dateCurrent = $dateCarbon->format('d');
        $monthCurrent = $dateCarbon->format('m');
        $dayAndMonth = $dateCurrent.'-'.$monthCurrent;

        // Utilizando o operador "LIKE" para comparar apenas o dia e o mês
        return self::whereRaw(
                "DATE_FORMAT(birthday, '%d-%m') LIKE ?", [$dayAndMonth.'%']
            );
    }

    public function getPermissionsAttribute()
    {
        return [
            'view_menu' => auth()->check() && $this->type === 'manager' ? true : false
        ];
    }
}
