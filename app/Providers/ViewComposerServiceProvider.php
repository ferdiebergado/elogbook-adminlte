<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            ['layouts.master', 'users::show'], 'Modules\Users\Http\ViewComposers\UsersComposer'
        );         
        // Using Closure based composers...
        //View::composer('dashboard', function ($view) {
            //
        //});
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}