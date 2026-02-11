<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\Sousmenu;
use App\Models\Role;
use App\Observers\SousmenuObserver;
use App\Observers\RoleObserver;
use Illuminate\Support\Facades\Route;
use App\Exceptions\Handler as AppHandler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Http\Middleware\CheckPermission;
use App\Models\Constance;
use App\Models\Currencie;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;
//use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->singleton(ExceptionHandler::class, AppHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

         if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // Définir la langue de l'application
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        } else {
            // Définir la langue par défaut si aucune n'est définie
            app()->setLocale(config('app.locale', 'fr'));
        }

        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $user = Auth::user();

            $menus = [];
            if ($user) {
                $accessibleSousMenus = $user->role->permissions->where('is_granted',true)->pluck('sousmenu_id')->toArray();

                $menus = Menu::with(['sousmenus' => function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus);
                }])->whereHas('sousmenus', function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus);
                })->get();
            }

            $view->with('mainmenus', $menus);
        });
       
        
        Sousmenu::observe(SousmenuObserver::class);
        Role::observe(RoleObserver::class);
        Route::aliasMiddleware('permission', CheckPermission::class);
        
        // Devise courante
        $currencyCode = 'XOF';

        if (Auth::check()) {
            $currencyCode = Auth::user()->preferred_currency ?? 'XOF';
        } elseif (session()->has('currency')) {
            $currencyCode = session('currency');
        }

        // $currentCurrency = Currencie::where('code', $currencyCode)->first()
        //     ?? Currencie::where('code', 'XOF')->first();

        // // Partager avec toutes les vues
        // View::share('currentCurrency', $currentCurrency);
    }
}
