<?php

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

class ImportApiTesterExtension extends Migration
{

    public function up()
    {
        $lastOrder = Menu::max('order') ?: 0;

        $root = [
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => 'Api tester',
            'icon' => 'fa-sliders',
            'uri' => 'api-tester',
        ];

        Menu::create($root);
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
