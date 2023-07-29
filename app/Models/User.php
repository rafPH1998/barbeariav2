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
use Illuminate\Support\Facades\DB;

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
        'type',
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

    protected function birthday(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y')     
        );
    }

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
        
        return self::select('id', 'name', 'image', 'birthday', 'created_at')
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
        return self::whereDay('birthday', '=',  $dateCarbon->format('d'))
                ->whereMonth('birthday', '=', $dateCarbon->format('m'));
    }

    public function getPermissionsAttribute()
    {
        return [
            'view_menu' => auth()->check() && $this->type === 'manager' || $this->type === 'employee' ? true : false
        ];
    }

    public function getPermissionsToEmployeeAttribute()
    {
        return [
            'view_button_store_employee' => auth()->check() && $this->type === 'manager' ? true : false,
            'store_employee' => auth()->check() && $this->type === 'manager' ? true : false,
            'update_employee' => auth()->check() && $this->type === 'manager' ? true : false,
            'delete_employee' => auth()->check() && $this->type === 'manager' ? true : false,
        ];
    }

    public function getBarbers()
    {
        $userId = auth()->user()->id;

        return $this
            ->select('users.id', 'users.name', 'users.image', 
                DB::raw('COUNT(likes.id) as likes_count'), 
                DB::raw('MAX(likes.user_id = '.$userId.') as like_status')
            )
            ->leftJoin('likes', 'users.id', '=', 'likes.barber')
            ->whereIn('users.type', ['manager', 'employee'])
            ->groupBy('users.id', 'users.name', 'users.image')
            ->get();
    }

}

