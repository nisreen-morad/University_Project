<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       

    \App\Models\Lab::create([
        'name' => 'Computer Lab 1',
        'floor' => 'First Floor',
        'status' => 'Available'
    ]);

    \App\Models\Lab::create([
        'name' => 'Physics Lab',
        'floor' => 'Second Floor',
        'status' => 'Full'
    ]);

    \App\Models\Lab::create([
        'name' => 'Chemistry Lab',
        'floor' => 'Third Floor',
        'status' => 'Maintenance'
    ]);

    }
}
