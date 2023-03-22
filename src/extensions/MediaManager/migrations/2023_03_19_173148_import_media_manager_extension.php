<?php

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class ImportMediaManagerExtension extends Migration
{

    public function up()
    {
        $lastOrder = Menu::max('order') ?: 0;

        $root = [
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => 'Media manager',
            'icon' => 'fa-file',
            'uri' => 'media',
        ];

        Menu::create($root);

        $this->createPermission('Media manager', 'ext.media-manager', 'media*');
    }

    public function down()
    {

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
