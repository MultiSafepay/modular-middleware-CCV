<?php

namespace ModularTemplate\ModularTemplate;

use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ModularTemplate\ModularTemplate\Commands\ModularTemplateCommand;
use function Sodium\add;

class ModularTemplateServiceProvider extends PackageServiceProvider
{

    public function boot(): void
    {
        //Load Custom routes into laravel
        $this->loadRoutesFrom(__DIR__ . '/routes/template.php');

        //Enable custom Horizon supervisor
        Config::set(
            'horizon.defaults.supervisor-template',
            [
                'connection' => 'redis',
                'queue' => ['default','template-high','template-low'],
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
            __DIR__.'/../config/template.php' => config_path('template.php'),
            //Migrations
            __DIR__.'/../database/migrations/create_modular_middleware_template_table.php.stub' => database_path('migrations/2022_01_31_101358_create_modular_middleware_template_table.php'),
            //Blades
            __DIR__.'/../resources/views/preference.blade.php' => resource_path('views/template/preference.blade.php'),
        ], 'modular-middleware');

        $package->name('modular-middleware-template');
    }
}
