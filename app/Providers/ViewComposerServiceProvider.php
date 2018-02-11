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
            ['layouts.master', 'users::show'], 'Modules\Users\Http\ViewComposers\UserComposer'
        );         
        View::composer(
            ['documents::*'], 'Modules\Documents\Http\ViewComposers\DoctypeComposer'
        );          
        View::composer(
            ['documents::*', 'users::*'], 'Modules\Documents\Http\ViewComposers\OfficeComposer'
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
