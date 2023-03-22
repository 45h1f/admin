<?php

namespace Ashiful\Admin\Console;

use Illuminate\Console\Command;

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

            $provider = "Extensions/{$item}/Providers/{$item}ServiceProvider.php";

            if (file_exists(base_path($provider))) {
                $this->error($item . ' Already Installed');
            } else {
                $this->copyFiles($item);
                $this->addProviderInConfig("\Ashiful\Extensions\\" . $item . "\Providers\\" . $item . "ServiceProvider::class,");
                $this->alert('php artisan migrate');
                $this->info($item . ' Extension Added successfully');
            }
        } else {
            $this->error('Invalid selection');
        }

    }

    public function extensions()
    {
        return [
            'LogViewer',
            'Helpers',
            'Backup',
            'Config',
            'ApiTester',
            "MediaManager"
        ];
    }

    public function addProviderInConfig($new_provider)
    {
        $config_file = config_path('app.php');
        $config_content = file_get_contents($config_file);

        $keyPosition = strpos($config_content, "{
                    $new_provider}");

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
        $installer = new InstallCommand();
        if ($item == 'LogViewer') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/LogViewerServiceProvider.stub", base_path("Extensions/{$item}/Providers/LogViewerServiceProvider.php"), base_path("Extensions/{$item}/Providers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/LogController.stub", base_path("Extensions/{$item}/Controllers/LogController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/resources/views/logs.blade.php", base_path("Extensions/{$item}/resources/views/logs.blade.php"), base_path("Extensions/{$item}/resources/views"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/LogViewer.stub", base_path("Extensions/{$item}/Services/LogViewer.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Traits/BootExtension.stub", base_path("Extensions/{$item}/Traits/BootExtension.php"), base_path("Extensions/{$item}/Traits"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/migrations/2023_03_19_173148_import_log_viewer_extension.php", base_path("Extensions/{$item}/migrations/2023_03_19_173148_import_log_viewer_extension.php"), base_path("Extensions/{$item}/migrations"));

        } elseif ($item == 'Helpers') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/HelpersServiceProvider.stub", base_path("Extensions/{$item}/Providers/HelpersServiceProvider.php"), base_path("Extensions/{$item}/Providers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/Helpers.stub", base_path("Extensions/{$item}/Services/Helpers.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/RouteController.stub", base_path("Extensions/{$item}/Controllers/RouteController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/ScaffoldController.stub", base_path("Extensions/{$item}/Controllers/ScaffoldController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/TerminalController.stub", base_path("Extensions/{$item}/Controllers/TerminalController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/resources/views/artisan.blade.php", base_path("extensions/{$item}/resources/views/artisan.blade.php"), base_path("extensions/{$item}/resources/views"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/resources/views/database.blade.php", base_path("extensions/{$item}/resources/views/database.blade.php"), base_path("extensions/{$item}/resources/views"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/resources/views/scaffold.blade.php", base_path("extensions/{$item}/resources/views/scaffold.blade.php"), base_path("extensions/{$item}/resources/views"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/Scaffold/ControllerCreator.stub", base_path("extensions/{$item}/Scaffold/ControllerCreator.php"), base_path("extensions/{$item}/Scaffold"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/Scaffold/MigrationCreator.stub", base_path("extensions/{$item}/Scaffold/MigrationCreator.php"), base_path("extensions/{$item}/Scaffold"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/Scaffold/ModelCreator.stub", base_path("extensions/{$item}/Scaffold/ModelCreator.php"), base_path("extensions/{$item}/Scaffold"));
            $installer->copy_dir(__DIR__ . " /../extensions/{$item}/Scaffold/stubs", base_path("extensions/{$item}/Scaffold/stubs"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_20_173148_import_helper_extension.php", base_path("extensions/{$item}/migrations/2023_03_20_173148_import_helper_extension.php"), base_path("extensions/{$item}/migrations"));

        } elseif ($item == 'Backup') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/BackupServiceProvider.stub", base_path("Extensions/{$item}/Providers/BackupServiceProvider.php"), base_path("Extensions/{$item}/Providers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/BackupController.stub", base_path("Extensions/{$item}/Controllers/BackupController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/resources/views/index.blade.php", base_path("extensions/{$item}/resources/views/index.blade.php"), base_path("extensions/{$item}/resources/views"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/Backup.stub", base_path("Extensions/{$item}/Services/Backup.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_21_173148_import_backup_extension.php", base_path("extensions/{$item}/migrations/2023_03_21_173148_import_backup_extension.php"), base_path("extensions/{$item}/migrations"));
            $this->alert('composer require spatie/laravel-backup');
        } elseif ($item == 'Config') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/ConfigServiceProvider.stub", base_path("Extensions/{$item}/Providers/ConfigServiceProvider.php"), base_path("Extensions/{$item}/Providers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/ConfigController.stub", base_path("Extensions/{$item}/Controllers/ConfigController.php"), base_path("Extensions/{$item}/Controllers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Models/Config.stub", base_path("Extensions/{$item}/Models/Config.php"), base_path("Extensions/{$item}/Models"));

            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/Config.stub", base_path("Extensions/{$item}/Services/Config.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_21_040159_create_config_table.php", base_path("extensions/{$item}/migrations/2023_03_21_040159_create_config_table.php"), base_path("extensions/{$item}/migrations"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_21_173148_import_config_extension.php", base_path("extensions/{$item}/migrations/2023_03_21_173148_import_config_extension.php"), base_path("extensions/{$item}/migrations"));

        } elseif ($item == 'ApiTester') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/ApiTesterServiceProvider.stub", base_path("Extensions/{$item}/Providers/ApiTesterServiceProvider.php"), base_path("Extensions/{$item}/Providers"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/ApiTesterController.stub", base_path("Extensions/{$item}/Controllers/ApiTesterController.php"), base_path("Extensions/{$item}/Controllers"));

            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/ApiLogger.stub", base_path("Extensions/{$item}/Services/ApiLogger.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/ApiTester.stub", base_path("Extensions/{$item}/Services/ApiTester.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/BootExtension.stub", base_path("Extensions/{$item}/Services/BootExtension.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_19_173148_import_api_tester_extension.php", base_path("extensions/{$item}/migrations/2023_03_19_173148_import_api_tester_extension.php"), base_path("extensions/{$item}/migrations"));

            $installer->copy_dir(__DIR__ . " /../extensions/{$item}/resources", base_path("extensions/{$item}/resources"));

        } elseif ($item == 'MediaManager') {
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Providers/MediaManagerServiceProvider.stub", base_path("Extensions/{$item}/Providers/MediaManagerServiceProvider.php"), base_path("Extensions/{$item}/Providers"));

            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Controllers/MediaController.stub", base_path("Extensions/{$item}/Controllers/MediaController.php"), base_path("Extensions/{$item}/Controllers"));

            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/MediaManager.stub", base_path("Extensions/{$item}/Services/MediaManager.php"), base_path("Extensions/{$item}/Services"));
            $installer->copy_file(__DIR__ . "/../extensions/{$item}/Services/BootExtension.stub", base_path("Extensions/{$item}/Services/BootExtension.php"), base_path("Extensions/{$item}/Services"));

            $installer->copy_file(__DIR__ . " /../extensions/{$item}/migrations/2023_03_19_173148_import_media_manager_extension.php", base_path("extensions/{$item}/migrations/2023_03_19_173148_import_media_manager_extension.php"), base_path("extensions/{$item}/migrations"));

            $installer->copy_dir(__DIR__ . " /../extensions/{$item}/resources", base_path("extensions/{$item}/resources"));

        }

    }


}
