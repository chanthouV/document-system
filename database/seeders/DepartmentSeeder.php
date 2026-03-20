<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'Human Resources', 'description' => 'HR Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'IT Department', 'description' => 'Information Technology'],
        ]);
    }
}
