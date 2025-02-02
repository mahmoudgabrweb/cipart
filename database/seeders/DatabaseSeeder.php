<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\MainModules\DatabaseSeeder as MainModulesDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'admin')->firstOrFail();

            User::create([
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
            ]);
        }

        $this->call([
            MainModulesDatabaseSeeder::class,
        ]);
    }
}
