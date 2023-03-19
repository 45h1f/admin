<?php

namespace Ashiful\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class  ExtensionCommand extends Command
{
    protected $signature = 'admin:extension';

    protected $description = 'Install extension in admin panel';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $extensions = $this->extensions();
        foreach ($extensions as $key => $extension) {
            $this->components->twoColumnDetail($extension, $key);
        }
        $ans = $this->components->ask('Select Extension');

        if (isset($extensions[$ans])) {
            $item = $extensions[$ans];

            $provider = "Extensions/LogViewer/Providers/{$item}ServiceProvider.php";
            if (file_exists(base_path($provider))) {
                $this->error($item . ' Already Installed');
            } else {
                $this->copyFiles($item);
                $this->addProviderInConfig("\Ashiful\Extensions\LogViewer\Providers\\" . $item . "ServiceProvider::class,");
                $this->importExtension($item);
                $this->info('Extension Added successfully');
            }
        } else {
            $this->error('Invalid selection');
        }

    }

    public function extensions()
    {
        return [
            'LogViewer'
        ];
    }

    public function addProviderInConfig($new_provider)
    {
        $config_file = config_path('app.php');
        $config_content = file_get_contents($config_file);

        $keyPosition = strpos($config_content, "{$new_provider}");
        if (!$keyPosition) {
            $regText = 'App\Providers\RouteServiceProvider::class,';
            $regTextCheck = strpos($config_content, "{$regText}");
            $begin = substr($config_content, 0, $regTextCheck + 42);
            $end = substr($config_content, $regTextCheck + 42);
            $config_contentUpdate = $begin . "\n" . $new_provider . "\n" . $end;
            file_put_contents($config_file, $config_contentUpdate);
        }
    }

    public function copyFiles($item)
    {
        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/Controllers"));
        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/Controllers/LogController.stub", base_path("Extensions/{$item}/Controllers/LogController.php"));

        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/Providers"));
        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/Providers/LogViewerServiceProvider.stub", base_path("Extensions/{$item}/Providers/LogViewerServiceProvider.php"));


        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/resources/views"));
        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/resources/views/logs.blade.php", base_path("Extensions/{$item}/resources/views/logs.blade.php"));

        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/Services"));
        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/Services/LogViewer.stub", base_path("Extensions/{$item}/Services/LogViewer.php"));

        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/Traits"));
        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/Traits/BootExtension.stub", base_path("Extensions/{$item}/Traits/BootExtension.php"));

    }

    public function importExtension($item)
    {
        (new Filesystem)->ensureDirectoryExists(base_path("Extensions/{$item}/migrations"));

        (new Filesystem)->copy(__DIR__ . "/../extensions/{$item}/migrations/2023_03_19_173148_import_log_viewer_extension.php", base_path("Extensions/{$item}/migrations/2023_03_19_173148_import_log_viewer_extension.php"));


    }

}
