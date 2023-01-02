<?php

namespace ModularCCV\ModularCCV;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ModularCCV\ModularCCV\Commands\ModularCCVCommand;
use function Sodium\add;

class ModularCCVServiceProvider extends PackageServiceProvider
{

    public function boot(): void
    {
        //Load Custom routes into laravel
        $this->loadRoutesFrom(__DIR__ . '/routes/ccv.php');

        //Enable custom Horizon supervisor
        Config::set(
            'horizon.defaults.supervisor-cvv',
            [
                'connection' => 'redis',
                'queue' => ['default','ccv-high','ccv-low'],
                'balance' => 'auto',
                'maxProcesses' => 2,
                'maxTime' => 0,
                'maxJobs' => 0,
                'memory' => 128,
                'tries' => 0,
                'timeout' => 60,
                'nice' => 0,
            ]
        );

    }

    public function configurePackage(Package $package): void
    {
        //Publish the required files
        $this->publishes([
            //Config
            __DIR__.'/../config/ccv.php' => config_path('ccv.php'),
            //Migrations
            __DIR__.'/../database/migrations/create_modular_middleware_ccv_table.php.stub' => database_path('migrations/2022_01_31_101358_create_modular_middleware_ccv_table.php'),
            //Blades
            __DIR__ . '/../resources/views/base.blade.php' => resource_path('views/ccv/base.blade.php'),
            __DIR__ . '/../resources/views/api.blade.php' => resource_path('views/ccv/api.blade.php'),
            //Images
            __DIR__.'/../resources/images/msp-logo-white.svg' => public_path('images/CCV/msp-logo-white.svg'),
        ], 'modular-middleware');

        $package->name('modular-middleware-ccv');
    }
}
