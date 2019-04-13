<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use View;
use App\User;
use App\Chat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $search = $request->search;
        View::share('search', $search);

        view()->composer('*', function ($view) 
        {
            $chatUsers = User::where('id', '!=', Auth::id())->get();
            $view->with('chatUsers', $chatUsers );    
            View::share('chatUsers', $chatUsers);
        

        $count = Chat::selectRaw('COUNT(case status when 0 then 1 else null end) AS c, from_id')
        ->where('to_id', Auth::id())
        ->groupBy('from_id')
        ->pluck('c', 'from_id');

        $countAll = Chat::where('to_id', Auth::id())
            ->where('status', 0)
            ->count();
            
        View::share('count', $count);
        View::share('countAll', $countAll);

        });
    }
}
