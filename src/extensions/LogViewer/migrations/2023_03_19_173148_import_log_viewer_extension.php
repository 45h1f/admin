<?php

use App\Models\Menu;
use App\Models\Permission;
use Ashiful\Extensions\LogViewer\Traits\BootExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

class ImportLogViewerExtension extends Migration
{
    use BootExtension;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->createMenu('Log viewer', 'logs', 'fa-database');

        $this->createPermission('Logs', 'ext.log-viewer', 'logs*');
    }

    public function down()
    {

    }

    public function createMenu($title, $uri, $icon = 'fa-bars', $parentId = 0, array $children = [])
    {
        $menuModel = Menu::class;

        $lastOrder = $menuModel::max('order');

        $menu = $menuModel::create([
            'parent_id' => $parentId,
            'order' => $lastOrder + 1,
            'title' => $title,
            'icon' => $icon,
            'uri' => $uri,
        ]);
        if (!empty($children)) {
            $extension = static::getInstance();
            foreach ($children as $child) {
                if ($extension->validateMenu($child)) {
                    $subTitle = Arr::get($child, 'title');
                    $subUri = Arr::get($child, 'path');
                    $subIcon = Arr::get($child, 'icon');
                    $subChildren = Arr::get($child, 'children', []);
                    static::createMenu($subTitle, $subUri, $subIcon, $menu->getKey(), $subChildren);
                }
            }
        }

        return $menu;
    }


    public function createPermission($name, $slug, $path, $methods = [])
    {

        Permission::create([
            'name' => $name,
            'slug' => $slug,
            'http_path' => '/' . trim($path, '/'),
            'http_method' => $methods,
        ]);
    }

}
