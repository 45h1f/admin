<?php

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class ImportSchedulingExtension extends Migration
{

    public function up()
    {
        $lastOrder = Menu::max('order') ?: 0;

        $root = [
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => 'Scheduling',
            'icon' => 'fa-clock-o',
            'uri' => 'scheduling',
        ];

        Menu::create($root);

        $this->createPermission('Scheduling', 'ext.scheduling', 'scheduling*');
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
