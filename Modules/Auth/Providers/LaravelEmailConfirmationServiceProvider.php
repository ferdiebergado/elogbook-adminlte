<?php

namespace Modules\Auth\Providers;

// use Illuminate\Support\ServiceProvider;

use Bestmomo\LaravelEmailConfirmation\ServiceProvider as ServiceProvider;
// use Nwidart\Modules\Module;

class LaravelEmailConfirmationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $vendor_namespace = 'Bestmomo\LaravelEmailConfirmation\\';

        // $packagePath = __DIR__.'/../';
        $packagePath = base_path('vendor/bestmomo/laravel-email-confirmation/');

        // Routes
        $this->app->router->group([
                'middleware' => 'web',
                'namespace' => 'Modules\Auth\Http\Controllers'
            ], function() {
                // $module = Module::find('auth');
                $moduleHttpPath = base_path('Modules/Auth/Http/');
                require $moduleHttpPath . 'confirmationroute.php';
            }
        );

        // Translations
        $translationsPath = $packagePath . 'publishable/translations';
        
        $this->loadTranslationsFrom($translationsPath, 'confirmation');

        $this->publishes([
            $translationsPath => resource_path('lang/vendor/confirmation'),
        ], 'confirmation:translations');

        // Migration
        $this->loadMigrationsFrom($packagePath . 'database/migrations');

        // Command
        if ($this->app->runningInConsole()) {
            $this->commands([
                $vendor_namespace . \Commands\AuthCommand::class,
                $vendor_namespace . \Commands\NotificationCommand::class,
            ]);
        }
    }

}
