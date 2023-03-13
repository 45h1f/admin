<?php

namespace Ashiful\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use function PHPUnit\Framework\fileExists;

class  InstallCommand extends Command
{
    protected $signature = 'admin:install';

    protected $description = 'Install dynamic admin panel';

    protected $dir = '';

    public function __construct()
    {
        parent::__construct();
        $this->dir = base_path('Admin');
        (new Filesystem)->ensureDirectoryExists($this->dir);
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
            $this->copyConfig();
            $this->copyHelper();
            $this->langCopy();
            $this->viewCopy();
            $this->assetCopy();
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
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Providers'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Providers/AdminServiceProvider.stub', base_path('Admin/Providers/AdminServiceProvider.php'));
        $this->components->info('provider copied...');

        $config_file = config_path('app.php');
        $addAdminProvider = '\Admin\Providers\AdminServiceProvider::class,';
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

    public function copyConfig()
    {
        (new Filesystem)->copy(__DIR__ . '/../../config/admin.php',base_path('config/admin.php'));
        $this->components->info('config copied...');
    }
    public function copyHelper()
    {
        $helper_path = $this->dir . '/Helpers';
        (new Filesystem)->ensureDirectoryExists($helper_path);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Helpers/admin.stub', $helper_path . '/admin.php');
        $this->components->info('helper copied...');
    }

    public function assetCopy()
    {

        $asset_path = public_path('admin/assets');
        (new Filesystem)->ensureDirectoryExists($asset_path);
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/assets', $asset_path);
        $this->components->info('assets copied...');
    }

    public function langCopy()
    {
        $this->copy_dir(__DIR__ . '/../../resources/lang', base_path('Admin/resources/lang'));
        $this->components->info('lang copied...');
    }

    public function viewCopy()
    {
        $this->copy_dir(__DIR__ . '/../../resources/views', base_path('Admin/resources/views'));
        $this->components->info('views copied...');
    }

    public function migrationCopy()
    {
        $this->copy_dir(__DIR__ . '/../../migrations', base_path('Admin/database/migrations'));
        $this->components->info('migrations copied...');
    }

    public function commendCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Console'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ActionCommand.stub', base_path('Admin/Console/ActionCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/AdminCommand.stub', base_path('Admin/Console/AdminCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ConfigCommand.stub', base_path('Admin/Console/ConfigCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ControllerCommand.stub', base_path('Admin/Console/ControllerCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/CreateUserCommand.stub', base_path('Admin/Console/CreateUserCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ExportSeedCommand.stub', base_path('Admin/Console/ExportSeedCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ExtendCommand.stub', base_path('Admin/Console/ExtendCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/FormCommand.stub', base_path('Admin/Console/FormCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/GenerateMenuCommand.stub', base_path('Admin/Console/GenerateMenuCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ImportCommand.stub', base_path('Admin/Console/ImportCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/InstallCommand.stub', base_path('Admin/Console/InstallCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MakeCommand.stub', base_path('Admin/Console/MakeCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MenuCommand.stub', base_path('Admin/Console/MenuCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/MinifyCommand.stub', base_path('Admin/Console/MinifyCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/PermissionCommand.stub', base_path('Admin/Console/PermissionCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/PublishCommand.stub', base_path('Admin/Console/PublishCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ResetPasswordCommand.stub', base_path('Admin/Console/ResetPasswordCommand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/ResourceGenerator.stub', base_path('Admin/Console/ResourceGenerator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Commend/UninstallCommand.stub', base_path('Admin/Console/UninstallCommand.php'));
        $this->components->info('commend copied...');
    }

    public function middlewareCopy()
    {
        $middleware = base_path('Admin/Http/Middleware');
        (new Filesystem)->ensureDirectoryExists($middleware);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/AdminAuthenticate.stub', base_path('Admin/Http/Middleware/AdminAuthenticate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Bootstrap.stub', base_path('Admin/Http/Middleware/Bootstrap.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/LogOperation.stub', base_path('Admin/Http/Middleware/LogOperation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Permission.stub', base_path('Admin/Http/Middleware/Permission.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Pjax.stub', base_path('Admin/Http/Middleware/Pjax.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Middleware/Session.stub', base_path('Admin/Http/Middleware/Session.php'));
        $this->components->info('middleware copied...');
    }

    public function routeCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/routes'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/routes/web.stub', base_path('Admin/routes/web.php'));
        $this->components->info('route copied...');
    }

    public function bootstrapCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/bootstrap'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/bootstrap/admin_bootstrap.stub', base_path('Admin/bootstrap/app.php'));
        $this->components->info('bootstrap copied...');
    }

    public function controllerCopy()
    {
        $controllerPath = base_path('Admin/Http/Controllers');
        (new Filesystem)->ensureDirectoryExists($controllerPath);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/AdminAuthController.stub', base_path('Admin/Http/Controllers/AdminAuthController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HomeController.stub', base_path('Admin/Http/Controllers/HomeController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/ExampleController.stub', base_path('Admin/Http/Controllers/ExampleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/AdminController.stub', base_path('Admin/Http/Controllers/AdminController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/Dashboard.stub', base_path('Admin/Http/Controllers/Dashboard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HandleController.stub', base_path('Admin/Http/Controllers/HandleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/HasResourceActions.stub', base_path('Admin/Http/Controllers/HasResourceActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/LogController.stub', base_path('Admin/Http/Controllers/LogController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/MenuController.stub', base_path('Admin/Http/Controllers/MenuController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/ModelForm.stub', base_path('Admin/Http/Controllers/ModelForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/PermissionController.stub', base_path('Admin/Http/Controllers/PermissionController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/RoleController.stub', base_path('Admin/Http/Controllers/RoleController.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Controllers/UserController.stub', base_path('Admin/Http/Controllers/UserController.php'));
    }

    public function actionCopy()
    {
        $actionPath = base_path('Admin/Http/Actions');
        (new Filesystem)->ensureDirectoryExists($actionPath);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Action.stub', base_path('Admin/Http/Actions/Action.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/BatchAction.stub', base_path('Admin/Http/Actions/BatchAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Dialog.stub', base_path('Admin/Http/Actions/Dialog.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Form.stub', base_path('Admin/Http/Actions/Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/GridAction.stub', base_path('Admin/Http/Actions/GridAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Interactor.stub', base_path('Admin/Http/Actions/Interactor.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Response.stub', base_path('Admin/Http/Actions/Response.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/RowAction.stub', base_path('Admin/Http/Actions/RowAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/SweatAlert2.stub', base_path('Admin/Http/Actions/SweatAlert2.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Actions/Toastr.stub', base_path('Admin/Http/Actions/Toastr.php'));

        $this->components->info('action copied...');
    }

    public function exceptionCopy()
    {
        $exceptionPath = base_path('Admin/Exceptions');
        (new Filesystem)->ensureDirectoryExists($exceptionPath);
        (new Filesystem)->copy(__DIR__ . '/../stubs/Exceptions/AdminHandler.stub', base_path('Admin/Exceptions/AdminHandler.php'));
        $this->components->info('exception copied...');
    }

    public function authCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Auth'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Permission.stub', base_path('Admin/Auth/Permission.php'));
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Auth/Database'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Administrator.stub', base_path('Admin/Auth/Database/Administrator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/AdminTablesSeeder.stub', base_path('Admin/Auth/Database/AdminTablesSeeder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/HasPermissions.stub', base_path('Admin/Auth/Database/HasPermissions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Menu.stub', base_path('Admin/Auth/Database/Menu.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/OperationLog.stub', base_path('Admin/Auth/Database/OperationLog.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Permission.stub', base_path('Admin/Auth/Database/Permission.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Auth/Database/Role.stub', base_path('Admin/Auth/Database/Role.php'));


        $this->components->info('auth copied...');
    }

    public function facadeCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Facades'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Facades/Admin.stub', base_path('Admin/Facades/Admin.php'));
        $this->components->info('facade copied...');
    }

    public function formCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Form'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Builder.stub', base_path('Admin/Form/Builder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/EmbeddedForm.stub', base_path('Admin/Form/EmbeddedForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field.stub', base_path('Admin/Form/Field.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Footer.stub', base_path('Admin/Form/Footer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/NestedForm.stub', base_path('Admin/Form/NestedForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Row.stub', base_path('Admin/Form/Row.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Tab.stub', base_path('Admin/Form/Tab.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Tools.stub', base_path('Admin/Form/Tools.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Form/Concerns'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HandleCascadeFields.stub', base_path('Admin/Form/Concerns/HandleCascadeFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HasFields.stub', base_path('Admin/Form/Concerns/HasFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Concerns/HasHooks.stub', base_path('Admin/Form/Concerns/HasHooks.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Form/Field'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsTo.stub', base_path('Admin/Form/Field/BelongsTo.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsToMany.stub', base_path('Admin/Form/Field/BelongsToMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/BelongsToRelation.stub', base_path('Admin/Form/Field/BelongsToRelation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Button.stub', base_path('Admin/Form/Field/Button.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CanCascadeFields.stub', base_path('Admin/Form/Field/CanCascadeFields.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Captcha.stub', base_path('Admin/Form/Field/Captcha.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CascadeGroup.stub', base_path('Admin/Form/Field/CascadeGroup.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Checkbox.stub', base_path('Admin/Form/Field/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CheckboxButton.stub', base_path('Admin/Form/Field/CheckboxButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/CheckboxCard.stub', base_path('Admin/Form/Field/CheckboxCard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Color.stub', base_path('Admin/Form/Field/Color.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Currency.stub', base_path('Admin/Form/Field/Currency.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Date.stub', base_path('Admin/Form/Field/Date.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DateMultiple.stub', base_path('Admin/Form/Field/DateMultiple.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DateRange.stub', base_path('Admin/Form/Field/DateRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Datetime.stub', base_path('Admin/Form/Field/Datetime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/DatetimeRange.stub', base_path('Admin/Form/Field/DatetimeRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Decimal.stub', base_path('Admin/Form/Field/Decimal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Display.stub', base_path('Admin/Form/Field/Display.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Divider.stub', base_path('Admin/Form/Field/Divider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Editor.stub', base_path('Admin/Form/Field/Editor.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Email.stub', base_path('Admin/Form/Field/Email.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Embeds.stub', base_path('Admin/Form/Field/Embeds.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Fieldset.stub', base_path('Admin/Form/Field/Fieldset.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/File.stub', base_path('Admin/Form/Field/File.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/HasMany.stub', base_path('Admin/Form/Field/HasMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/HasValuePicker.stub', base_path('Admin/Form/Field/HasValuePicker.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Hidden.stub', base_path('Admin/Form/Field/Hidden.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Html.stub', base_path('Admin/Form/Field/Html.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Icon.stub', base_path('Admin/Form/Field/Icon.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Id.stub', base_path('Admin/Form/Field/Id.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Image.stub', base_path('Admin/Form/Field/Image.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ImageField.stub', base_path('Admin/Form/Field/ImageField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Ip.stub', base_path('Admin/Form/Field/Ip.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/KeyValue.stub', base_path('Admin/Form/Field/KeyValue.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Listbox.stub', base_path('Admin/Form/Field/Listbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ListField.stub', base_path('Admin/Form/Field/ListField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Map.stub', base_path('Admin/Form/Field/Map.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Mobile.stub', base_path('Admin/Form/Field/Mobile.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Month.stub', base_path('Admin/Form/Field/Month.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleFile.stub', base_path('Admin/Form/Field/MultipleFile.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleImage.stub', base_path('Admin/Form/Field/MultipleImage.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/MultipleSelect.stub', base_path('Admin/Form/Field/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Nullable.stub', base_path('Admin/Form/Field/Nullable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Number.stub', base_path('Admin/Form/Field/Number.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Password.stub', base_path('Admin/Form/Field/Password.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/PlainInput.stub', base_path('Admin/Form/Field/PlainInput.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Radio.stub', base_path('Admin/Form/Field/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/RadioButton.stub', base_path('Admin/Form/Field/RadioButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/RadioCard.stub', base_path('Admin/Form/Field/RadioCard.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Rate.stub', base_path('Admin/Form/Field/Rate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Select.stub', base_path('Admin/Form/Field/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Slider.stub', base_path('Admin/Form/Field/Slider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/SwitchField.stub', base_path('Admin/Form/Field/SwitchField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Table.stub', base_path('Admin/Form/Field/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Tags.stub', base_path('Admin/Form/Field/Tags.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Text.stub', base_path('Admin/Form/Field/Text.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Textarea.stub', base_path('Admin/Form/Field/Textarea.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Time.stub', base_path('Admin/Form/Field/Time.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/TimeRange.stub', base_path('Admin/Form/Field/TimeRange.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Timezone.stub', base_path('Admin/Form/Field/Timezone.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/UploadField.stub', base_path('Admin/Form/Field/UploadField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Url.stub', base_path('Admin/Form/Field/Url.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/ValuePicker.stub', base_path('Admin/Form/Field/ValuePicker.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Field/Year.stub', base_path('Admin/Form/Field/Year.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Form/Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Layout/Column.stub', base_path('Admin/Form/Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Form/Layout/Layout.stub', base_path('Admin/Form/Layout/Layout.php'));

        $this->components->info('form copied...');
    }

    public function gridCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column.stub', base_path('Admin/Grid/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporter.stub', base_path('Admin/Grid/Exporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter.stub', base_path('Admin/Grid/Filter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Model.stub', base_path('Admin/Grid/Model.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Row.stub', base_path('Admin/Grid/Row.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable.stub', base_path('Admin/Grid/Selectable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Simple.stub', base_path('Admin/Grid/Simple.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools.stub', base_path('Admin/Grid/Tools.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Actions'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Delete.stub', base_path('Admin/Grid/Actions/Delete.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Edit.stub', base_path('Admin/Grid/Actions/Edit.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Actions/Show.stub', base_path('Admin/Grid/Actions/Show.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Column'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/CheckFilter.stub', base_path('Admin/Grid/Column/CheckFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/ExtendDisplay.stub', base_path('Admin/Grid/Column/ExtendDisplay.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Filter.stub', base_path('Admin/Grid/Column/Filter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/HasHeader.stub', base_path('Admin/Grid/Column/HasHeader.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Help.stub', base_path('Admin/Grid/Column/Help.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/InlineEditing.stub', base_path('Admin/Grid/Column/InlineEditing.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/InputFilter.stub', base_path('Admin/Grid/Column/InputFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/RangeFilter.stub', base_path('Admin/Grid/Column/RangeFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Column/Sorter.stub', base_path('Admin/Grid/Column/Sorter.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Concerns'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanDoubleClick.stub', base_path('Admin/Grid/Concerns/CanDoubleClick.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanExportGrid.stub', base_path('Admin/Grid/Concerns/CanExportGrid.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanFixColumns.stub', base_path('Admin/Grid/Concerns/CanFixColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/CanHidesColumns.stub', base_path('Admin/Grid/Concerns/CanHidesColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasActions.stub', base_path('Admin/Grid/Concerns/HasActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasElementNames.stub', base_path('Admin/Grid/Concerns/HasElementNames.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasFilter.stub', base_path('Admin/Grid/Concerns/HasFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasFooter.stub', base_path('Admin/Grid/Concerns/HasFooter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHeader.stub', base_path('Admin/Grid/Concerns/HasHeader.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHotKeys.stub', base_path('Admin/Grid/Concerns/HasHotKeys.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasHotKeys.stub', base_path('Admin/Grid/Concerns/HasHotKeys.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasQuickCreate.stub', base_path('Admin/Grid/Concerns/HasQuickCreate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasQuickSearch.stub', base_path('Admin/Grid/Concerns/HasQuickSearch.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasSelector.stub', base_path('Admin/Grid/Concerns/HasSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasTools.stub', base_path('Admin/Grid/Concerns/HasTools.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Concerns/HasTotalRow.stub', base_path('Admin/Grid/Concerns/HasTotalRow.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Displayers'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/AbstractDisplayer.stub', base_path('Admin/Grid/Displayers/AbstractDisplayer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Actions.stub', base_path('Admin/Grid/Displayers/Actions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Badge.stub', base_path('Admin/Grid/Displayers/Badge.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/BelongsTo.stub', base_path('Admin/Grid/Displayers/BelongsTo.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/BelongsToMany.stub', base_path('Admin/Grid/Displayers/BelongsToMany.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Button.stub', base_path('Admin/Grid/Displayers/Button.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Carousel.stub', base_path('Admin/Grid/Displayers/Carousel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Checkbox.stub', base_path('Admin/Grid/Displayers/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/ContextMenuActions.stub', base_path('Admin/Grid/Displayers/ContextMenuActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Copyable.stub', base_path('Admin/Grid/Displayers/Copyable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Datetime.stub', base_path('Admin/Grid/Displayers/Datetime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Downloadable.stub', base_path('Admin/Grid/Displayers/Downloadable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/DropdownActions.stub', base_path('Admin/Grid/Displayers/DropdownActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Editable.stub', base_path('Admin/Grid/Displayers/Editable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Expand.stub', base_path('Admin/Grid/Displayers/Expand.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Image.stub', base_path('Admin/Grid/Displayers/Image.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Input.stub', base_path('Admin/Grid/Displayers/Input.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Label.stub', base_path('Admin/Grid/Displayers/Label.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Limit.stub', base_path('Admin/Grid/Displayers/Limit.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Link.stub', base_path('Admin/Grid/Displayers/Link.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Modal.stub', base_path('Admin/Grid/Displayers/Modal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/MultipleSelect.stub', base_path('Admin/Grid/Displayers/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Orderable.stub', base_path('Admin/Grid/Displayers/Orderable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Prefix.stub', base_path('Admin/Grid/Displayers/Prefix.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/ProgressBar.stub', base_path('Admin/Grid/Displayers/ProgressBar.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/QRCode.stub', base_path('Admin/Grid/Displayers/QRCode.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Radio.stub', base_path('Admin/Grid/Displayers/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/RowSelector.stub', base_path('Admin/Grid/Displayers/RowSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Secret.stub', base_path('Admin/Grid/Displayers/Secret.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Select.stub', base_path('Admin/Grid/Displayers/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Suffix.stub', base_path('Admin/Grid/Displayers/Suffix.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/SwitchDisplay.stub', base_path('Admin/Grid/Displayers/SwitchDisplay.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/SwitchGroup.stub', base_path('Admin/Grid/Displayers/SwitchGroup.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Table.stub', base_path('Admin/Grid/Displayers/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Textarea.stub', base_path('Admin/Grid/Displayers/Textarea.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Displayers/Upload.stub', base_path('Admin/Grid/Displayers/Upload.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Exporters'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/AbstractExporter.stub', base_path('Admin/Grid/Exporters/AbstractExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/CsvExporter.stub', base_path('Admin/Grid/Exporters/CsvExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/ExcelExporter.stub', base_path('Admin/Grid/Exporters/ExcelExporter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Exporters/ExporterInterface.stub', base_path('Admin/Grid/Exporters/ExporterInterface.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Filter'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/AbstractFilter.stub', base_path('Admin/Grid/Filter/AbstractFilter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Between.stub', base_path('Admin/Grid/Filter/Between.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Date.stub', base_path('Admin/Grid/Filter/Date.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Day.stub', base_path('Admin/Grid/Filter/Day.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/EndsWith.stub', base_path('Admin/Grid/Filter/EndsWith.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Equal.stub', base_path('Admin/Grid/Filter/Equal.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Group.stub', base_path('Admin/Grid/Filter/Group.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Gt.stub', base_path('Admin/Grid/Filter/Gt.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Hidden.stub', base_path('Admin/Grid/Filter/Hidden.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Ilike.stub', base_path('Admin/Grid/Filter/Ilike.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/In.stub', base_path('Admin/Grid/Filter/In.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Like.stub', base_path('Admin/Grid/Filter/Like.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Lt.stub', base_path('Admin/Grid/Filter/Lt.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Month.stub', base_path('Admin/Grid/Filter/Month.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/NotEqual.stub', base_path('Admin/Grid/Filter/NotEqual.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/NotIn.stub', base_path('Admin/Grid/Filter/NotIn.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Scope.stub', base_path('Admin/Grid/Filter/Scope.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/StartsWith.stub', base_path('Admin/Grid/Filter/StartsWith.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Where.stub', base_path('Admin/Grid/Filter/Where.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Year.stub', base_path('Admin/Grid/Filter/Year.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Filter/Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Layout/Column.stub', base_path('Admin/Grid/Filter/Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Layout/Layout.stub', base_path('Admin/Grid/Filter/Layout/Layout.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Filter/Presenter'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Checkbox.stub', base_path('Admin/Grid/Filter/Presenter/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/DateTime.stub', base_path('Admin/Grid/Filter/Presenter/DateTime.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/MultipleSelect.stub', base_path('Admin/Grid/Filter/Presenter/MultipleSelect.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Presenter.stub', base_path('Admin/Grid/Filter/Presenter/Presenter.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Radio.stub', base_path('Admin/Grid/Filter/Presenter/Radio.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Select.stub', base_path('Admin/Grid/Filter/Presenter/Select.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Filter/Presenter/Text.stub', base_path('Admin/Grid/Filter/Presenter/Text.php'));


        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Selectable'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/BrowserBtn.stub', base_path('Admin/Grid/Selectable/BrowserBtn.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/Checkbox.stub', base_path('Admin/Grid/Selectable/Checkbox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Selectable/Radio.stub', base_path('Admin/Grid/Selectable/Radio.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Grid/Tools'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/AbstractTool.stub', base_path('Admin/Grid/Tools/AbstractTool.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchAction.stub', base_path('Admin/Grid/Tools/BatchAction.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchActions.stub', base_path('Admin/Grid/Tools/BatchActions.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/BatchDelete.stub', base_path('Admin/Grid/Tools/BatchDelete.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/ColumnSelector.stub', base_path('Admin/Grid/Tools/ColumnSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/CreateButton.stub', base_path('Admin/Grid/Tools/CreateButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/ExportButton.stub', base_path('Admin/Grid/Tools/ExportButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/FilterButton.stub', base_path('Admin/Grid/Tools/FilterButton.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/FixColumns.stub', base_path('Admin/Grid/Tools/FixColumns.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Footer.stub', base_path('Admin/Grid/Tools/Footer.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Header.stub', base_path('Admin/Grid/Tools/Header.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Paginator.stub', base_path('Admin/Grid/Tools/Paginator.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/PerPageSelector.stub', base_path('Admin/Grid/Tools/PerPageSelector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/QuickCreate.stub', base_path('Admin/Grid/Tools/QuickCreate.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/QuickSearch.stub', base_path('Admin/Grid/Tools/QuickSearch.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/Selector.stub', base_path('Admin/Grid/Tools/Selector.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Grid/Tools/TotalRow.stub', base_path('Admin/Grid/Tools/TotalRow.php'));

        $this->components->info('grid copied...');
    }

    public function layoutCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Layout'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Buildable.stub', base_path('Admin/Layout/Buildable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Column.stub', base_path('Admin/Layout/Column.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Content.stub', base_path('Admin/Layout/Content.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Layout/Row.stub', base_path('Admin/Layout/Row.php'));
        $this->components->info('layout copied...');
    }

    public function showCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Show'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/AbstractField.stub', base_path('Admin/Show/AbstractField.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Divider.stub', base_path('Admin/Show/Divider.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Field.stub', base_path('Admin/Show/Field.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Panel.stub', base_path('Admin/Show/Panel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Relation.stub', base_path('Admin/Show/Relation.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Show/Tools.stub', base_path('Admin/Show/Tools.php'));

        $this->components->info('show copied...');
    }

    public function treeCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Tree'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Tree/Tools.stub', base_path('Admin/Tree/Tools.php'));
        $this->components->info('tree copied...');
    }

    public function traitCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Traits'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/Authorizable.stub', base_path('Admin/Traits/Authorizable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/AdminBuilder.stub', base_path('Admin/Traits/AdminBuilder.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/DefaultDatetimeFormat.stub', base_path('Admin/Traits/DefaultDatetimeFormat.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/HasAssets.stub', base_path('Admin/Traits/HasAssets.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/ModelTree.stub', base_path('Admin/Traits/ModelTree.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/Resizable.stub', base_path('Admin/Traits/Resizable.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Traits/ShouldSnakeAttributes.stub', base_path('Admin/Traits/ShouldSnakeAttributes.php'));
        $this->components->info('trait copied...');
    }

    public function widgetCopy()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Widgets'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Alert.stub', base_path('Admin/Widgets/Alert.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Box.stub', base_path('Admin/Widgets/Box.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Callout.stub', base_path('Admin/Widgets/Callout.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Carousel.stub', base_path('Admin/Widgets/Carousel.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Collapse.stub', base_path('Admin/Widgets/Collapse.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/ContainsForms.stub', base_path('Admin/Widgets/ContainsForms.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Form.stub', base_path('Admin/Widgets/Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/InfoBox.stub', base_path('Admin/Widgets/InfoBox.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/MultipleSteps.stub', base_path('Admin/Widgets/MultipleSteps.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar.stub', base_path('Admin/Widgets/Navbar.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/StepForm.stub', base_path('Admin/Widgets/StepForm.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Tab.stub', base_path('Admin/Widgets/Tab.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Table.stub', base_path('Admin/Widgets/Table.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Widget.stub', base_path('Admin/Widgets/Widget.php'));

        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Widgets/Navbar'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar/Fullscreen.stub', base_path('Admin/Widgets/Navbar/Fullscreen.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Widgets/Navbar/RefreshButton.stub', base_path('Admin/Widgets/Navbar/RefreshButton.php'));


        $this->components->info('widget copied...');
    }


    public function copyService()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('Admin/Services'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Admin.stub', base_path('Admin/Services/Admin.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Extension.stub', base_path('Admin/Services/Extension.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Form.stub', base_path('Admin/Services/Form.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Grid.stub', base_path('Admin/Services/Grid.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Show.stub', base_path('Admin/Services/Show.php'));
        (new Filesystem)->copy(__DIR__ . '/../stubs/Services/Tree.stub', base_path('Admin/Services/Tree.php'));
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
}
