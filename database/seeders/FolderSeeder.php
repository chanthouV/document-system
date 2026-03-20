<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('folders')->insert([
            [
                'name' => 'HR Policies',
                'department_id' => 1,
                'created_by' => 1
            ],
            [
                'name' => 'Financial Reports',
                'department_id' => 2,
                'created_by' => 2
            ],
        ]);
    }
}
