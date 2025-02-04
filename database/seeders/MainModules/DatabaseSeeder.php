<?php

namespace Database\Seeders\MainModules;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountryPermissionSeeder::class,
            CityPermissionSeeder::class,
            CurrencyPermissionSeeder::class,
            FaqPermissionSeeder::class,
            ReturnReasonPermissionSeeder::class,
            VehicleMakerPermissionSeeder::class,
            VehicleModelPermissionSeeder::class,
            ManufactureYearPermissionSeeder::class,
            VehicleStatusPermissionSeeder::class,
            PetrolTypePermissionSeeder::class,
            GearTypePermissionSeeder::class,
            PropulsionTypePermissionSeeder::class,
            BodyTypePermissionSeeder::class,
            CylinderPermissionSeeder::class,
            WeightPermissionSeeder::class,
            WidthPermissionSeeder::class,
            HeightPermissionSeeder::class,
            LengthPermissionSeeder::class,
        ]);
    }
}
