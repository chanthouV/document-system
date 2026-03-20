<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('documents')->insert([
            [
                'name' => 'Employee Handbook 2024',
                'file_path' => 'documents/hr/employee_handbook_2024.pdf',
                'file_size' => '2.5MB',
                'file_type' => 'PDF',
                'status' => 'approved',
                'folder_id' => 1,
                'user_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Q1 Financial Report',
                'file_path' => 'documents/finance/q1_2024_report.xlsx',
                'file_size' => '1.8MB',
                'file_type' => 'Excel',
                'status' => 'pending',
                'folder_id' => 2,
                'user_id' => 2,
                'department_id' => 2
            ],
            [
                'name' => 'IT Security Policy',
                'file_path' => 'documents/it/security_policy.pdf',
                'file_size' => '1.2MB',
                'file_type' => 'PDF',
                'status' => 'approved',
                'folder_id' => null,
                'user_id' => 1,
                'department_id' => 3
            ],
        ]);
    }
}
