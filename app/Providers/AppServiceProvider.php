<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en','fr']); // also accepts a closure
        });
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch

                ->flags([
                    'ar' => asset('flags/ksa-6.svg'),
                    'fr' => asset('flags/france-15.svg'),
                    'en' => asset('flags/usa-6.svg'),
                ])
                ->flagsOnly();

        });
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->visible(outsidePanels: true);
        });
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->outsidePanelRoutes([
                    'profile',
                    'home',
                    // Additional custom routes where the switcher should be visible outside panels
                ]);
        });
    }
}
