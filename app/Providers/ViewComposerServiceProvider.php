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
            ['users::show'], 'Modules\Users\Http\ViewComposers\JobtitleComposer'
        );              
        View::composer(
            ['documents::*'], 'Modules\Documents\Http\ViewComposers\DoctypeComposer'
        );          
        View::composer(
            ['documents::*', 'users::*'], 'Modules\Documents\Http\ViewComposers\OfficeComposer'
        );          
        View::composer(
            ['layouts.master'], 'Modules\Documents\Http\ViewComposers\DocumentComposer'
        );      
        View::composer(
            ['layouts.master'], 'Modules\Documents\Http\ViewComposers\TransactionComposer'
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
