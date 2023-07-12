<?php

namespace SmirlTech\LaravelFcm\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use SmirlTech\LaravelFcm\Services\LaravelFcm;
use SmirlTech\LaravelFcm\Channels\FirebaseChannel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelFcmServiceProvider extends PackageServiceProvider
{


    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-fcm')
            ->hasConfigFile();
    }

    /**
     * Register any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function registeringPackage(): void
    {
        $app = $this->app;

        $this->app->make(ChannelManager::class)->extend('firebase', function () use ($app) {
            return $app->make(FirebaseChannel::class);
        });

       /* $this->mergeConfigFrom(
            __DIR__. '../../Config/larafirebase.php',
            'larafirebase'
        );*/
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
       /* $this->publishes([
            __DIR__. '/../Config/larafirebase.php' => config_path('larafirebase.php'),
        ]);

        $this->app->bind('larafirebase', LaravelFcm::class);*/
    }
}
