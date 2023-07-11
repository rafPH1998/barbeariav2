<?php

namespace App\Http\Middleware;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $user = null;
        
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $user = User::withCount(['agenda' => function ($query) {
                $query->where('status', 'pendente');
            }])->find($userId);

            $countSchedules = Schedule::where('status', '=', 'pendente')->get();
        }

        return array_merge(parent::share($request), [
            'csrf' => csrf_token(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'dates' => fn () => $request->session()->get('dates'),
                'user' => fn () => auth()->check() ? $user : null,
                'countSchedules' => auth()->check() ? $countSchedules : null
            ],
            'birthdaysOfTheDay' => $user ? $user->getUserBirthdayData()->count() : 0,
            'permissions' => $user ? $user->permissions ?? '' : ''
        ]);
    }
}
