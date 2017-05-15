<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AutosController;
use App\AutoverhuurPattern\Gateway\Auto_DataGateway;
use App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository;
use App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository;
use App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository;

class AutosProvider extends ServiceProvider
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
        $this->app->bind(
            'App\AutoverhuurPattern\Interfaces\Huren_dataInterface',
            'App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository'
        );
        $this->app->bind(
            'App\AutoverhuurPattern\Interfaces\Klanten_dataInterface',
            'App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository'
        );
        $this->app->bind(
            'App\AutoverhuurPattern\Interfaces\Autos_dataInterface',
            'App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository'
        );

        $this->app->bind('App\Http\Controllers\AutosController',  function()   {
            return new AutosController($this->app->make('App\AutoverhuurPattern\Gateway\Auto_DataGateway'));});


        $this->app->bind('App\AutoverhuurPattern\Gateway\Auto_DataGateway', function()   {
            return new Auto_DataGateway($this->app->make('App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository'), $this->app->make('App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository'),
            $this->app->make('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository')); });
        
            

        $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository', function()   {
            return new EloquentHuren_dataRepository($this->app->make('App\Huren'));       });
        
        $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository', function()   {
            return new EloquentKlanten_dataRepository($this->app->make('App\Klanten'));       });    
            
        $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository', function()   {
            return new EloquentAutos_dataRepository($this->app->make('App\Autos'));       });  
    }
}
