<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\HurenController;
use App\AutoverhuurPattern\Gateway\Huren_DataGateway;
use App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository;
use App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository;
use App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository;
use App\AutoverhuurPattern\Repositories\EloquentKwitantie_dataRepository;
class AutoverhuurProvider extends ServiceProvider
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

        $this->app->bind('App\Http\Controllers\HurenController',  function()   {
            return new HurenController($this->app->make('App\AutoverhuurPattern\Gateway\Huren_DataGateway'));});


        $this->app->bind('App\AutoverhuurPattern\Gateway\Huren_DataGateway', function()   {
            return new Huren_DataGateway($this->app->make('App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository'), $this->app->make('App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository'),
            $this->app->make('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository'), $this->app->make('App\AutoverhuurPattern\Repositories\EloquentKwitantie_dataRepository')); });
        
            

        $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentHuren_dataRepository', function()   {
            return new EloquentHuren_dataRepository($this->app->make('App\Huren'),$this->app->make('App\AutoverhuurPattern\Repositories\EloquentKwitantie_dataRepository'),$this->app->make('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository') );    });
         $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository', function()   {
            return new EloquentAutos_dataRepository($this->app->make('App\Autos'));       });
         $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentKlanten_dataRepository', function()   {
            return new EloquentKlanten_dataRepository($this->app->make('App\Klanten'));       });
        
        $this->app->bind('App\AutoverhuurPattern\Repositories\EloquentKwitantie_dataRepository', function()   {
            return new EloquentKwitantie_dataRepository($this->app->make('App\Kwitantie'),$this->app->make('App\AutoverhuurPattern\Repositories\EloquentAutos_dataRepository') ); });    
    }
}
