<?php

namespace Ashiful\Admin;

use Ashiful\Admin\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerCommands();
    }

    public function register()
    {

    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
