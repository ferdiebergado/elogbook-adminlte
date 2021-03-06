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
            ['sections.usernav', 'users::show'], 'Modules\Users\Http\ViewComposers\UserComposer'
        ); 
        View::composer(
            ['documents::transactions.partial'], 'Modules\Users\Http\ViewComposers\UsersComposer'
        );             
        View::composer(
            ['users::show'], 'Modules\Users\Http\ViewComposers\JobtitleComposer'
        );              
        View::composer(
            ['documents::*'], 'Modules\Documents\Http\ViewComposers\DoctypeComposer'
        );          
        View::composer(
            ['documents::transactions.*', 'users::*'], 'Modules\Documents\Http\ViewComposers\OfficeComposer'
        );          
        View::composer(
            [ 'documents::offices'], 'Modules\Documents\Http\ViewComposers\ActiveOfficesComposer'
        );          
        // Active Offices Count
        View::composer(
            ['layouts.master'], 'Modules\Documents\Http\ViewComposers\ActiveOfficesCountComposer'
        );          
        // Document Count
        View::composer(
            ['layouts.master'], 'Modules\Documents\Http\ViewComposers\DocumentComposer'
        );      
        View::composer(
            ['layouts.master'], 'Modules\Documents\Http\ViewComposers\TransactionComposer'
        );                
        View::composer(
            ['documents::transactions.partial'], 'Modules\Documents\Http\ViewComposers\ActionsComposer'
        );         
        View::composer(
            ['layouts.master'], 'App\Http\ViewComposers\VersionComposer'
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
