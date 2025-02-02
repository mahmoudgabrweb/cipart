<?php

namespace Database\Seeders\MainModules;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class VehicleMakerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelName = "vehicle_makers";

        //Permissions
        Permission::generateFor($modelName);

        $upperCase = ucfirst($modelName);
        $upperCaseSingular = "VehicleMaker";
        $controllerName = "VehicleMakerController";
        $iconClass = "voyager-hotdog";

        //Data Type
        $dataType = DataType::firstOrNew(["name" => $modelName]);
        if (!$dataType->exists) {
            $dataType->fill([
                'slug' => $modelName,
                'display_name_singular' => $upperCaseSingular,
                'display_name_plural' => $upperCase,
                'icon' => $iconClass,
                'model_name' => "App\\Models\\$upperCaseSingular",
                'controller' => "App\\Http\\Controllers\\Admin\\$controllerName",
                'generate_permissions' => 1,
                'description' => '',
                'server_side' => 1,
                'details' => '{"order_column":"id","order_display_column":"id","order_direction":"desc","default_search_key":"name"}',
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => $upperCase,
            'url' => '',
            'route' => "voyager.$modelName.index",
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => $iconClass,
                'color' => null,
                'parent_id' => null,
                'order' => 8,
            ])->save();
        }
    }
}
