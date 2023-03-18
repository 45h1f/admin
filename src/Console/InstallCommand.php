<?php

namespace Ashiful\Admin\Console;

use App\Auth\Database\AdminTablesSeeder;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;

class  InstallCommand extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install dynamic admin panel';

    protected $dir = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->installAdminFiles();

        $this->initDatabase();
    }

    public function initDatabase()
    {
        $this->call('migrate');

        $userModel = config('admin.database.users_model');

        if ($userModel::count() == 0) {
            $this->call('db:seed', ['--class' => AdminTablesSeeder::class]);
        }
    }

    protected function installAdminFiles()
    {
        $ans = $this->components->ask('You want to install admin panel. It Will be replace files. [y/n]', 'y');
        if (strtolower($ans) != 'n') {
            $this->components->info('Starting Installation.');
            $this->copyConfig();
            $this->copyHelper();
            $this->assetCopy();
            $this->langCopy();
            $this->viewCopy();
            $this->migrationCopy();
            $this->commendCopy();
            $this->middlewareCopy();
            $this->routeCopy();
            $this->bootstrapCopy();
            $this->controllerCopy();
            $this->actionCopy();
            $this->exceptionCopy();
            $this->authCopy();
            $this->facadeCopy();
            $this->formCopy();
            $this->gridCopy();
            $this->layoutCopy();
            $this->showCopy();
            $this->treeCopy();
            $this->traitCopy();
            $this->widgetCopy();
            $this->copyService();
            $this->providerCopy();
            $this->components->info('Admin installed successfully.');
        } else {
            $this->components->info('Canceled Installation');
        }

    }

    public function providerCopy()
    {
        $this->copy_file(__DIR__ . '/../stubs/Providers/AdminServiceProvider.stub', base_path('App/Providers/AdminServiceProvider.php'), app_path('Providers'));
        $this->components->info('provider copied...');

        $config_file = config_path('app.php');
        $addAdminProvider = '\App\Providers\AdminServiceProvider::class,';
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

        $addAdminFacade = '\'Admin\' => App\Facades\Admin::class,';

        $keyPosition = strpos($config_content, "{$addAdminFacade}");
        if (!$keyPosition) {
            $regText2 = '\'aliases\' => Facade::defaultAliases()->merge([';
            $regText2Check = strpos($config_content, "{$regText2}");
            $begin = substr($config_content, 0, $regText2Check + 50);
            $end = substr($config_content, $regText2Check + 50);
            $config_contentUpdate2 = $begin . "\n" . $addAdminFacade . "\n" . $end;
            file_put_contents($config_file, $config_contentUpdate2);
        }
        $this->components->info('add in provider...');
    }

    public function copyConfig()
    {
        $this->copy_file(__DIR__ . '/../../config/admin.php', base_path('config/admin.php'), base_path('config'));
        $this->components->info('config copied...');
    }

    public function copyHelper()
    {
        $this->copy_file(__DIR__ . '/../stubs/Helpers/admin.stub', app_path('Helpers/admin.php'), app_path('Helpers'));
        $this->components->info('helper copied...');
    }

    public function assetCopy()
    {
        $this->copy_dir(__DIR__ . '/../../resources/assets', public_path('assets'));
        $this->components->info('assets copied...');
    }

    public function langCopy()
    {
        $this->copy_dir(__DIR__ . '/../../resources/lang', app()->langPath());
        $this->components->info('lang copied...');
    }

    public function viewCopy()
    {
        $this->copy_dir(__DIR__ . '/../../resources/views', app()->viewPath('admin'));
        $this->components->info('views copied...');
    }

    public function migrationCopy()
    {
        $this->copy_dir(__DIR__ . '/../../migrations', base_path('database/migrations'));
        $this->components->info('migrations copied...');
    }

    public function commendCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Console'));
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
        (new Filesystem)->ensureDirectoryExists(base_path('routes'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/routes/web.stub', base_path('routes/admin.php'));
        $this->components->info('route copied...');
    }

    public function bootstrapCopy()
    {
        $this->copy_file(__DIR__ . '/../stubs/bootstrap/admin_bootstrap.stub', base_path('bootstrap/admin_app.php'), base_path('bootstrap'));
        $this->components->info('bootstrap copied...');
    }

    public function controllerCopy()
    {
        $controllerPath = app_path('Http/Controllers');
        (new Filesystem)->ensureDirectoryExists($controllerPath);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/AdminAuthController.stub', app_path('Http/Controllers/AdminAuthController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HomeController.stub', app_path('Http/Controllers/HomeController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/ExampleController.stub', app_path('Http/Controllers/ExampleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/AdminController.stub', app_path('Http/Controllers/AdminController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/Dashboard.stub', app_path('Http/Controllers/Dashboard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HandleController.stub', app_path('Http/Controllers/HandleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HasResourceActions.stub', app_path('Http/Controllers/HasResourceActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/LogController.stub', app_path('Http/Controllers/LogController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/MenuController.stub', app_path('Http/Controllers/MenuController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/ModelForm.stub', app_path('Http/Controllers/ModelForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/PermissionController.stub', app_path('Http/Controllers/PermissionController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/RoleController.stub', app_path('Http/Controllers/RoleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/UserController.stub', app_path('Http/Controllers/UserController.php'));
    }

    public function actionCopy()
    {
        $actionPath = app_path('Actions');
        (new Filesystem)->ensureDirectoryExists($actionPath);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Action.stub', app_path('Actions/Action.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/BatchAction.stub', app_path('Actions/BatchAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Dialog.stub', app_path('Actions/Dialog.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Form.stub', app_path('Actions/Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/GridAction.stub', app_path('Actions/GridAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Interactor.stub', app_path('Actions/Interactor.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Response.stub', app_path('Actions/Response.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/RowAction.stub', app_path('Actions/RowAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/SweatAlert2.stub', app_path('Actions/SweatAlert2.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Toastr.stub', app_path('Actions/Toastr.php'));

        $this->components->info('action copied...');
    }

    public function exceptionCopy()
    {
        $this->copy_file(__DIR__ . '/../stubs/Exceptions/AdminHandler.stub', app_path('Exceptions/AdminHandler.php'), app_path('Exceptions'));
        $this->components->info('exception copied...');
    }

    public function authCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Auth'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Permission.stub', app_path('Auth/Permission.php'));
        (new Filesystem)->ensureDirectoryExists(app_path('Auth/Database'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Administrator.stub', app_path('Auth/Database/Administrator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/AdminTablesSeeder.stub', app_path('Auth/Database/AdminTablesSeeder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/HasPermissions.stub', app_path('Auth/Database/HasPermissions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Menu.stub', app_path('Auth/Database/Menu.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/OperationLog.stub', app_path('Auth/Database/OperationLog.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Permission.stub', app_path('Auth/Database/Permission.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Role.stub', app_path('Auth/Database/Role.php'));


        $this->components->info('auth copied...');
    }

    public function facadeCopy()
    {
        $this->copy_file(__DIR__ . '/../stubs/Facades/Admin.stub', app_path('Facades/Admin.php'), app_path('Facades'));
        $this->components->info('facade copied...');
    }

    public function formCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Form'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Builder.stub', app_path('Form/Builder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/EmbeddedForm.stub', app_path('Form/EmbeddedForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field.stub', app_path('Form/Field.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Footer.stub', app_path('Form/Footer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/NestedForm.stub', app_path('Form/NestedForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Row.stub', app_path('Form/Row.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Tab.stub', app_path('Form/Tab.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Tools.stub', app_path('Form/Tools.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Form/Concerns'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HandleCascadeFields.stub', app_path('Form/Concerns/HandleCascadeFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HasFields.stub', app_path('Form/Concerns/HasFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HasHooks.stub', app_path('Form/Concerns/HasHooks.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Form/Field'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsTo.stub', app_path('Form/Field/BelongsTo.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsToMany.stub', app_path('Form/Field/BelongsToMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsToRelation.stub', app_path('Form/Field/BelongsToRelation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Button.stub', app_path('Form/Field/Button.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CanCascadeFields.stub', app_path('Form/Field/CanCascadeFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Captcha.stub', app_path('Form/Field/Captcha.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CascadeGroup.stub', app_path('Form/Field/CascadeGroup.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Checkbox.stub', app_path('Form/Field/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CheckboxButton.stub', app_path('Form/Field/CheckboxButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CheckboxCard.stub', app_path('Form/Field/CheckboxCard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Color.stub', app_path('Form/Field/Color.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Currency.stub', app_path('Form/Field/Currency.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Date.stub', app_path('Form/Field/Date.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DateMultiple.stub', app_path('Form/Field/DateMultiple.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DateRange.stub', app_path('Form/Field/DateRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Datetime.stub', app_path('Form/Field/Datetime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DatetimeRange.stub', app_path('Form/Field/DatetimeRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Decimal.stub', app_path('Form/Field/Decimal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Display.stub', app_path('Form/Field/Display.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Divider.stub', app_path('Form/Field/Divider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Editor.stub', app_path('Form/Field/Editor.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Email.stub', app_path('Form/Field/Email.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Embeds.stub', app_path('Form/Field/Embeds.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Fieldset.stub', app_path('Form/Field/Fieldset.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/File.stub', app_path('Form/Field/File.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/HasMany.stub', app_path('Form/Field/HasMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/HasValuePicker.stub', app_path('Form/Field/HasValuePicker.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Hidden.stub', app_path('Form/Field/Hidden.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Html.stub', app_path('Form/Field/Html.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Icon.stub', app_path('Form/Field/Icon.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Id.stub', app_path('Form/Field/Id.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Image.stub', app_path('Form/Field/Image.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ImageField.stub', app_path('Form/Field/ImageField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Ip.stub', app_path('Form/Field/Ip.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/KeyValue.stub', app_path('Form/Field/KeyValue.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Listbox.stub', app_path('Form/Field/Listbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ListField.stub', app_path('Form/Field/ListField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Map.stub', app_path('Form/Field/Map.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Mobile.stub', app_path('Form/Field/Mobile.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Month.stub', app_path('Form/Field/Month.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleFile.stub', app_path('Form/Field/MultipleFile.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleImage.stub', app_path('Form/Field/MultipleImage.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleSelect.stub', app_path('Form/Field/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Nullable.stub', app_path('Form/Field/Nullable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Number.stub', app_path('Form/Field/Number.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Password.stub', app_path('Form/Field/Password.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/PlainInput.stub', app_path('Form/Field/PlainInput.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Radio.stub', app_path('Form/Field/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/RadioButton.stub', app_path('Form/Field/RadioButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/RadioCard.stub', app_path('Form/Field/RadioCard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Rate.stub', app_path('Form/Field/Rate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Select.stub', app_path('Form/Field/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Slider.stub', app_path('Form/Field/Slider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/SwitchField.stub', app_path('Form/Field/SwitchField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Table.stub', app_path('Form/Field/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Tags.stub', app_path('Form/Field/Tags.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Text.stub', app_path('Form/Field/Text.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Textarea.stub', app_path('Form/Field/Textarea.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Time.stub', app_path('Form/Field/Time.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/TimeRange.stub', app_path('Form/Field/TimeRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Timezone.stub', app_path('Form/Field/Timezone.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/UploadField.stub', app_path('Form/Field/UploadField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Url.stub', app_path('Form/Field/Url.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ValuePicker.stub', app_path('Form/Field/ValuePicker.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Year.stub', app_path('Form/Field/Year.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Form/Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Layout/Column.stub', app_path('Form/Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Layout/Layout.stub', app_path('Form/Layout/Layout.php'));

        $this->components->info('form copied...');
    }

    public function gridCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Grid'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column.stub', app_path('Grid/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporter.stub', app_path('Grid/Exporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter.stub', app_path('Grid/Filter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Model.stub', app_path('Grid/Model.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Row.stub', app_path('Grid/Row.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable.stub', app_path('Grid/Selectable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Simple.stub', app_path('Grid/Simple.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools.stub', app_path('Grid/Tools.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Actions'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Delete.stub', app_path('Grid/Actions/Delete.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Edit.stub', app_path('Grid/Actions/Edit.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Show.stub', app_path('Grid/Actions/Show.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Column'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/CheckFilter.stub', app_path('Grid/Column/CheckFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/ExtendDisplay.stub', app_path('Grid/Column/ExtendDisplay.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Filter.stub', app_path('Grid/Column/Filter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/HasHeader.stub', app_path('Grid/Column/HasHeader.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Help.stub', app_path('Grid/Column/Help.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/InlineEditing.stub', app_path('Grid/Column/InlineEditing.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/InputFilter.stub', app_path('Grid/Column/InputFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/RangeFilter.stub', app_path('Grid/Column/RangeFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Sorter.stub', app_path('Grid/Column/Sorter.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Concerns'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanDoubleClick.stub', app_path('Grid/Concerns/CanDoubleClick.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanExportGrid.stub', app_path('Grid/Concerns/CanExportGrid.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanFixColumns.stub', app_path('Grid/Concerns/CanFixColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanFixHeader.stub', app_path('Grid/Concerns/CanFixHeader.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanHidesColumns.stub', app_path('Grid/Concerns/CanHidesColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasActions.stub', app_path('Grid/Concerns/HasActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasElementNames.stub', app_path('Grid/Concerns/HasElementNames.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasFilter.stub', app_path('Grid/Concerns/HasFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasFooter.stub', app_path('Grid/Concerns/HasFooter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHeader.stub', app_path('Grid/Concerns/HasHeader.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHotKeys.stub', app_path('Grid/Concerns/HasHotKeys.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHotKeys.stub', app_path('Grid/Concerns/HasHotKeys.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasQuickCreate.stub', app_path('Grid/Concerns/HasQuickCreate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasQuickSearch.stub', app_path('Grid/Concerns/HasQuickSearch.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasSelector.stub', app_path('Grid/Concerns/HasSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasTools.stub', app_path('Grid/Concerns/HasTools.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasTotalRow.stub', app_path('Grid/Concerns/HasTotalRow.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Displayers'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/AbstractDisplayer.stub', app_path('Grid/Displayers/AbstractDisplayer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Actions.stub', app_path('Grid/Displayers/Actions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Badge.stub', app_path('Grid/Displayers/Badge.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/BelongsTo.stub', app_path('Grid/Displayers/BelongsTo.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/BelongsToMany.stub', app_path('Grid/Displayers/BelongsToMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Button.stub', app_path('Grid/Displayers/Button.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Carousel.stub', app_path('Grid/Displayers/Carousel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Checkbox.stub', app_path('Grid/Displayers/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/ContextMenuActions.stub', app_path('Grid/Displayers/ContextMenuActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Copyable.stub', app_path('Grid/Displayers/Copyable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Datetime.stub', app_path('Grid/Displayers/Datetime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Downloadable.stub', app_path('Grid/Displayers/Downloadable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/DropdownActions.stub', app_path('Grid/Displayers/DropdownActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Editable.stub', app_path('Grid/Displayers/Editable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Expand.stub', app_path('Grid/Displayers/Expand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Image.stub', app_path('Grid/Displayers/Image.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Input.stub', app_path('Grid/Displayers/Input.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Label.stub', app_path('Grid/Displayers/Label.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Limit.stub', app_path('Grid/Displayers/Limit.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Link.stub', app_path('Grid/Displayers/Link.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Modal.stub', app_path('Grid/Displayers/Modal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/MultipleSelect.stub', app_path('Grid/Displayers/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Orderable.stub', app_path('Grid/Displayers/Orderable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Prefix.stub', app_path('Grid/Displayers/Prefix.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/ProgressBar.stub', app_path('Grid/Displayers/ProgressBar.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/QRCode.stub', app_path('Grid/Displayers/QRCode.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Radio.stub', app_path('Grid/Displayers/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/RowSelector.stub', app_path('Grid/Displayers/RowSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Secret.stub', app_path('Grid/Displayers/Secret.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Select.stub', app_path('Grid/Displayers/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Suffix.stub', app_path('Grid/Displayers/Suffix.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/SwitchDisplay.stub', app_path('Grid/Displayers/SwitchDisplay.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/SwitchGroup.stub', app_path('Grid/Displayers/SwitchGroup.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Table.stub', app_path('Grid/Displayers/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Textarea.stub', app_path('Grid/Displayers/Textarea.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Upload.stub', app_path('Grid/Displayers/Upload.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Exporters'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/AbstractExporter.stub', app_path('Grid/Exporters/AbstractExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/CsvExporter.stub', app_path('Grid/Exporters/CsvExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/ExcelExporter.stub', app_path('Grid/Exporters/ExcelExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/ExporterInterface.stub', app_path('Grid/Exporters/ExporterInterface.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Filter'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/AbstractFilter.stub', app_path('Grid/Filter/AbstractFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Between.stub', app_path('Grid/Filter/Between.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Date.stub', app_path('Grid/Filter/Date.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Day.stub', app_path('Grid/Filter/Day.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/EndsWith.stub', app_path('Grid/Filter/EndsWith.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Equal.stub', app_path('Grid/Filter/Equal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Group.stub', app_path('Grid/Filter/Group.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Gt.stub', app_path('Grid/Filter/Gt.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Hidden.stub', app_path('Grid/Filter/Hidden.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Ilike.stub', app_path('Grid/Filter/Ilike.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/In.stub', app_path('Grid/Filter/In.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Like.stub', app_path('Grid/Filter/Like.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Lt.stub', app_path('Grid/Filter/Lt.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Month.stub', app_path('Grid/Filter/Month.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/NotEqual.stub', app_path('Grid/Filter/NotEqual.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/NotIn.stub', app_path('Grid/Filter/NotIn.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Scope.stub', app_path('Grid/Filter/Scope.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/StartsWith.stub', app_path('Grid/Filter/StartsWith.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Where.stub', app_path('Grid/Filter/Where.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Year.stub', app_path('Grid/Filter/Year.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Filter/Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Layout/Column.stub', app_path('Grid/Filter/Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Layout/Layout.stub', app_path('Grid/Filter/Layout/Layout.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Filter/Presenter'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Checkbox.stub', app_path('Grid/Filter/Presenter/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/DateTime.stub', app_path('Grid/Filter/Presenter/DateTime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/MultipleSelect.stub', app_path('Grid/Filter/Presenter/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Presenter.stub', app_path('Grid/Filter/Presenter/Presenter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Radio.stub', app_path('Grid/Filter/Presenter/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Select.stub', app_path('Grid/Filter/Presenter/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Text.stub', app_path('Grid/Filter/Presenter/Text.php'));


        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Selectable'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/BrowserBtn.stub', app_path('Grid/Selectable/BrowserBtn.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/Checkbox.stub', app_path('Grid/Selectable/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/Radio.stub', app_path('Grid/Selectable/Radio.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Grid/Tools'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/AbstractTool.stub', app_path('Grid/Tools/AbstractTool.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchAction.stub', app_path('Grid/Tools/BatchAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchActions.stub', app_path('Grid/Tools/BatchActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchDelete.stub', app_path('Grid/Tools/BatchDelete.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/ColumnSelector.stub', app_path('Grid/Tools/ColumnSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/CreateButton.stub', app_path('Grid/Tools/CreateButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/ExportButton.stub', app_path('Grid/Tools/ExportButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/FilterButton.stub', app_path('Grid/Tools/FilterButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/FixColumns.stub', app_path('Grid/Tools/FixColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Footer.stub', app_path('Grid/Tools/Footer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Header.stub', app_path('Grid/Tools/Header.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Paginator.stub', app_path('Grid/Tools/Paginator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/PerPageSelector.stub', app_path('Grid/Tools/PerPageSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/QuickCreate.stub', app_path('Grid/Tools/QuickCreate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/QuickSearch.stub', app_path('Grid/Tools/QuickSearch.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Selector.stub', app_path('Grid/Tools/Selector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/TotalRow.stub', app_path('Grid/Tools/TotalRow.php'));

        $this->components->info('grid copied...');
    }

    public function layoutCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Buildable.stub', app_path('Layout/Buildable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Column.stub', app_path('Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Content.stub', app_path('Layout/Content.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Row.stub', app_path('Layout/Row.php'));
        $this->components->info('layout copied...');
    }

    public function showCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Show'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/AbstractField.stub', app_path('Show/AbstractField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Divider.stub', app_path('Show/Divider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Field.stub', app_path('Show/Field.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Panel.stub', app_path('Show/Panel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Relation.stub', app_path('Show/Relation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Tools.stub', app_path('Show/Tools.php'));

        $this->components->info('show copied...');
    }

    public function treeCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Tree'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Tree/Tools.stub', app_path('Tree/Tools.php'));
        $this->components->info('tree copied...');
    }

    public function traitCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Traits'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/Authorizable.stub', app_path('Traits/Authorizable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/AdminBuilder.stub', app_path('Traits/AdminBuilder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/DefaultDatetimeFormat.stub', app_path('Traits/DefaultDatetimeFormat.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/HasAssets.stub', app_path('Traits/HasAssets.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/ModelTree.stub', app_path('Traits/ModelTree.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/Resizable.stub', app_path('Traits/Resizable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/ShouldSnakeAttributes.stub', app_path('Traits/ShouldSnakeAttributes.php'));
        $this->components->info('trait copied...');
    }

    public function widgetCopy()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Widgets'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Alert.stub', app_path('Widgets/Alert.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Box.stub', app_path('Widgets/Box.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Callout.stub', app_path('Widgets/Callout.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Carousel.stub', app_path('Widgets/Carousel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Collapse.stub', app_path('Widgets/Collapse.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/ContainsForms.stub', app_path('Widgets/ContainsForms.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Form.stub', app_path('Widgets/Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/InfoBox.stub', app_path('Widgets/InfoBox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/MultipleSteps.stub', app_path('Widgets/MultipleSteps.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar.stub', app_path('Widgets/Navbar.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/StepForm.stub', app_path('Widgets/StepForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Tab.stub', app_path('Widgets/Tab.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Table.stub', app_path('Widgets/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Widget.stub', app_path('Widgets/Widget.php'));

        (new Filesystem)->ensureDirectoryExists(app_path('Widgets/Navbar'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar/Fullscreen.stub', app_path('Widgets/Navbar/Fullscreen.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar/RefreshButton.stub', app_path('Widgets/Navbar/RefreshButton.php'));


        $this->components->info('widget copied...');
    }


    public function copyService()
    {
        (new Filesystem)->copy(__DIR__ . '/../stubs/Admin.stub', app_path('Admin.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Extension.stub', app_path('Extension.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form.stub', app_path('Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid.stub', app_path('Grid.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show.stub', app_path('Show.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Tree.stub', app_path('Tree.php'));
        $this->components->info('service copied...');
    }

    public function copy_dir(string $from, string $to): bool
    {
        try {
            (new Filesystem)->ensureDirectoryExists($to);
            (new Filesystem)->copyDirectory($from, $to);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function copy_file(string $from, string $to, string $folder): bool
    {
        try {
            (new Filesystem)->ensureDirectoryExists($folder);
            (new Filesystem)->copy($from, $to);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
