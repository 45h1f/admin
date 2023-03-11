<?php

namespace Ashiful\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class  InstallCommand extends Command
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
            $this->assetCopy();
            $this->langCopy();
            $this->viewCopy();
            $this->migrationCopy();
            $this->providerCopy();
            $this->commendCopy();
            $this->middlewareCopy();
            $this->routeCopy();
            $this->bootstrapCopy();
            $this->controllerCopy();
            $this->components->info('Admin installed successfully.');
        } else {
            $this->components->info('Canceled Installation');
        }

    }

    public function assetCopy()
    {
        $asset_path = public_path('assets');
        (new Filesystem)->ensureDirectoryExists($asset_path);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/assets', $asset_path);
        $this->components->info('assets copied...');
    }

    public function langCopy()
    {
        $lang_path = App::langPath();
        (new Filesystem)->ensureDirectoryExists($lang_path);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/lang', $lang_path);
        $this->components->info('lang copied...');
    }

    public function viewCopy()
    {
        $view_path = resource_path('views/backend');
        (new Filesystem)->ensureDirectoryExists($view_path);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views', $view_path);
        $this->components->info('views copied...');
    }

    public function migrationCopy()
    {
        $database_path = database_path('migrations');
        (new Filesystem)->ensureDirectoryExists($database_path);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../migrations', $database_path);

        $this->components->info('migrations copied...');
    }

    public function providerCopy()
    {
        (new Filesystem)->copy(__DIR__ . '/../stubs/Providers/AdminServiceProvider.stub', app_path('Providers/AdminServiceProvider.php'));
        $this->components->info('provider copied...');

        $config_file = config_path('app.php');
        $addAdminProvider = 'App\Providers\AdminServiceProvider::class,';
        $config_content = file_get_contents($config_file);
        $keyPosition = strpos($config_content, "{$addAdminProvider}");
        if (!$keyPosition) {
            $regText = 'App\Providers\RouteServiceProvider::class,';
            $regTextCheck = strpos($config_content, "{$regText}");
            $begin = substr($config_content, 0, $regTextCheck + 42);
            $end = substr($config_content, $regTextCheck + 42);
            $config_contentUpdate = $begin . "\n" . $addAdminProvider . "\n" . $end;
            file_put_contents($config_file, $config_contentUpdate);
        }
        $this->components->info('add in provider...');
    }

    public function commendCopy()
    {
        $commend = app_path('Console');
        (new Filesystem)->ensureDirectoryExists($commend);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ActionCommand.stub', app_path('Console/ActionCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/AdminCommand.stub', app_path('Console/AdminCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ConfigCommand.stub', app_path('Console/ConfigCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ControllerCommand.stub', app_path('Console/ControllerCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/CreateUserCommand.stub', app_path('Console/CreateUserCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ExportSeedCommand.stub', app_path('Console/ExportSeedCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ExtendCommand.stub', app_path('Console/ExtendCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/FormCommand.stub', app_path('Console/FormCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/GenerateMenuCommand.stub', app_path('Console/GenerateMenuCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ImportCommand.stub', app_path('Console/ImportCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/InstallCommand.stub', app_path('Console/InstallCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MakeCommand.stub', app_path('Console/MakeCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MenuCommand.stub', app_path('Console/MenuCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MinifyCommand.stub', app_path('Console/MinifyCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/PermissionCommand.stub', app_path('Console/PermissionCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/PublishCommand.stub', app_path('Console/PublishCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ResetPasswordCommand.stub', app_path('Console/ResetPasswordCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ResourceGenerator.stub', app_path('Console/ResourceGenerator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/UninstallCommand.stub', app_path('Console/UninstallCommand.php'));
        $this->components->info('commend copied...');
    }

    public function middlewareCopy()
    {
        $middleware = app_path('Http/Middleware');
        (new Filesystem)->ensureDirectoryExists($middleware);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/AdminAuthenticate.stub', app_path('Http/Middleware/AdminAuthenticate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Bootstrap.stub', app_path('Http/Middleware/Bootstrap.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/LogOperation.stub', app_path('Http/Middleware/LogOperation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Permission.stub', app_path('Http/Middleware/Permission.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Pjax.stub', app_path('Http/Middleware/Pjax.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Session.stub', app_path('Http/Middleware/Session.php'));
        $this->components->info('middleware copied...');
    }

    public function routeCopy()
    {
        (new Filesystem)->copy(__DIR__ . '/../stubs/routes/admin.stub', app_path('../routes/admin.php'));
        $this->components->info('route copied...');
    }

    public function bootstrapCopy()
    {
        (new Filesystem)->copy(__DIR__ . '/../stubs/bootstrap/admin_bootstrap.stub', app_path('../bootstrap/admin.php'));
        $this->components->info('bootstrap copied...');
    }

    public function controllerCopy()
    {
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/AuthController.stub', app_path('Http/Controllers/AuthController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HomeController.stub', app_path('Http/Controllers/HomeController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/ExampleController.stub', app_path('Http/Controllers/ExampleController.php'));
    }
}
