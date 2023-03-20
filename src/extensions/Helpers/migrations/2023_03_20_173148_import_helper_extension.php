<?php

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class ImportHelperExtension extends Migration
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
            'title' => 'Helpers',
            'icon' => 'fa-gears',
            'uri' => '',
        ];

        $root = Menu::create($root);

        $menus = [
            [
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
            ],
            [
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
            ],
            [
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
            ],
            [
                'title' => 'Routes',
                'icon' => 'fa-list-alt',
                'uri' => 'helpers/routes',
            ],
        ];

        foreach ($menus as $menu) {
            $menu['parent_id'] = $root->id;
            $menu['order'] = $lastOrder++;

            Menu::create($menu);
        }

        $this->createPermission('Admin helpers', 'ext.helpers', 'helpers/*');
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
