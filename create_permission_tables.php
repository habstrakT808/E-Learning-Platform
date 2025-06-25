<?php
// Load Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// SQL to create all permission tables
$sql = "
-- Create permissions table
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permissions_name_guard_name_unique` (`name`, `guard_name`)
);

-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_name_guard_name_unique` (`name`, `guard_name`)
);

-- Create model_has_permissions table
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
    KEY `model_has_permissions_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
);

-- Create model_has_roles table
CREATE TABLE IF NOT EXISTS `model_has_roles` (
    `role_id` BIGINT UNSIGNED NOT NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `model_id`, `model_type`),
    KEY `model_has_roles_model_id_model_type_index` (`model_id`, `model_type`),
    CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
);

-- Create role_has_permissions table
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`permission_id`, `role_id`),
    KEY `role_has_permissions_role_id_foreign` (`role_id`),
    CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
);
";

// Execute the SQL
try {
    \DB::unprepared($sql);
    echo "Permission tables created successfully!\n";
    
    // Insert default roles
    $roles = [
        ['name' => 'admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'instructor', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'student', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
    ];
    
    foreach ($roles as $role) {
        if (!\DB::table('roles')->where('name', $role['name'])->exists()) {
            \DB::table('roles')->insert($role);
        }
    }
    echo "Default roles created!\n";
    
    // Assign roles to users
    $admin = \DB::table('users')->where('email', 'admin@example.com')->first();
    $instructor = \DB::table('users')->where('email', 'instructor@example.com')->first();
    $student = \DB::table('users')->where('email', 'student@example.com')->first();
    
    if ($admin) {
        if (!\DB::table('model_has_roles')->where(['model_id' => $admin->id, 'model_type' => 'App\\Models\\User'])->exists()) {
            \DB::table('model_has_roles')->insert([
                'role_id' => \DB::table('roles')->where('name', 'admin')->first()->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $admin->id
            ]);
        }
        echo "Admin role assigned to admin@example.com\n";
    }
    
    if ($instructor) {
        if (!\DB::table('model_has_roles')->where(['model_id' => $instructor->id, 'model_type' => 'App\\Models\\User'])->exists()) {
            \DB::table('model_has_roles')->insert([
                'role_id' => \DB::table('roles')->where('name', 'instructor')->first()->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $instructor->id
            ]);
        }
        echo "Instructor role assigned to instructor@example.com\n";
    }
    
    if ($student) {
        if (!\DB::table('model_has_roles')->where(['model_id' => $student->id, 'model_type' => 'App\\Models\\User'])->exists()) {
            \DB::table('model_has_roles')->insert([
                'role_id' => \DB::table('roles')->where('name', 'student')->first()->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $student->id
            ]);
        }
        echo "Student role assigned to student@example.com\n";
    }
    
    echo "\nAll permissions tables created and roles assigned successfully!\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 