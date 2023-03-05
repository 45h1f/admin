<?php

namespace Ashiful\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class InstallCommand extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install dynamic admin panel';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->installAdminRelegatedFiles();
    }

    protected function installAdminRelegatedFiles()
    {
        $ans = $this->components->ask('You want to install admin panel. It Will be replace files. [y/n]', 'y');
        if (strtolower($ans) != 'n') {
            $this->components->info('Starting Installation.');

            $asset_path = public_path('assets');
            (new Filesystem)->ensureDirectoryExists($asset_path);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/assets', $asset_path);

            $lang_path = App::langPath();
            (new Filesystem)->ensureDirectoryExists($lang_path);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/lang', $lang_path);


            $view_path = resource_path('views/backend');
            (new Filesystem)->ensureDirectoryExists($view_path);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views', $view_path);


            $view_path = resource_path('views/backend');
            (new Filesystem)->ensureDirectoryExists($view_path);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views', $view_path);


            $database_path = database_path('migrations');
            (new Filesystem)->ensureDirectoryExists($database_path);
            (new Filesystem)->copyDirectory(__DIR__ . '/../../migrations', $database_path);


            $this->components->info('Admin installed successfully.');
        } else {
            $this->components->info('Canceled Installation');
        }

    }
}
