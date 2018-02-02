<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Modules\Users\Repositories\UserRepository::class, \Modules\Users\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\Modules\Documents\Repositories\DocumentRepository::class, \Modules\Documents\Repositories\DocumentRepositoryEloquent::class);        
    }
}
