<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
use App\Models\Departments;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            FolderSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
