<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = \App\Models\Role::create(['name' => 'admin']);
        $staffRole = \App\Models\Role::create(['name' => 'staff']);

        // Create Admin User
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@raagasbeach.com',
            'password' => bcrypt('admin123'),
            'role_id' => $adminRole->id,
        ]);

        // Create Staff User
        User::create([
            'name' => 'Front Desk Staff',
            'email' => 'staff@raagasbeach.com',
            'password' => bcrypt('staff123'),
            'role_id' => $staffRole->id,
        ]);

        // Create some sample cottages
        $cottage = \App\Models\Cottage::create([
            'name' => 'Ocean View Deluxe',
            'slug' => 'ocean-view-deluxe',
            'description' => 'A beautiful cottage with a direct view of the ocean.',
            'capacity' => 4,
            'price' => 5500.00,
            'status' => 'available',
        ]);

        $cottage->inclusions()->createMany([
            ['inclusion_name' => 'Free Breakfast'],
            ['inclusion_name' => 'Air Conditioning'],
            ['inclusion_name' => 'Flat Screen TV'],
        ]);
    }
}
