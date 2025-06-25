<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $instructor = Role::create(['name' => 'instructor']);
        $student = Role::create(['name' => 'student']);

        // Create permissions
        $permissions = [
            'manage users',
            'manage courses',
            'create courses',
            'edit courses',
            'delete courses',
            'publish courses',
            'enroll courses',
            'view enrolled courses',
            'manage categories',
            'view reports',
            'manage reviews',
            'view analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all());
        
        $instructor->givePermissionTo([
            'create courses',
            'edit courses',
            'delete courses',
            'publish courses',
            'view reports',
            'view analytics',
            'manage reviews'
        ]);
        
        $student->givePermissionTo([
            'enroll courses',
            'view enrolled courses'
        ]);
    }
}