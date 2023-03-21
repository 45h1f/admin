<?php

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class ImportBackupExtension extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lastOrder = Menu::max('order') ?: 0;

        $root = [
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => 'Backup',
            'icon' => 'fa-copy',
            'uri' => 'backup',
        ];

        Menu::create($root);

        $this->createPermission('Backup', 'ext.backup', 'backup*');
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
