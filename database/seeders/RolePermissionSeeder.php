<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full access, manage everything'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Manage content, settings, users'],
            ['name' => 'Validator', 'slug' => 'validator', 'description' => 'Validate UMKM/IKM & products'],
            ['name' => 'UMKM/IKM', 'slug' => 'umkm-ikm', 'description' => 'Manage own profile & products'],
            ['name' => 'Guest', 'slug' => 'guest', 'description' => 'Browse public pages'],
        ];

        DB::table('roles')->insert($roles);

        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage_users', 'description' => 'CRUD users & assign roles'],
            ['name' => 'Manage Roles', 'slug' => 'manage_roles', 'description' => 'CRUD roles & permissions'],
            ['name' => 'Validate UMKM', 'slug' => 'validate_umkm', 'description' => 'Approve/reject UMKM/IKM registration'],
            ['name' => 'Validate Products', 'slug' => 'validate_products', 'description' => 'Approve/reject products/services'],
            ['name' => 'Manage Own Products', 'slug' => 'manage_own_products', 'description' => 'UMKM/IKM CRUD own products/services'],
            ['name' => 'Manage Own Profile', 'slug' => 'manage_own_profile', 'description' => 'UMKM/IKM edit own profile'],
            ['name' => 'Manage News', 'slug' => 'manage_news', 'description' => 'CRUD berita'],
            ['name' => 'Manage Pages', 'slug' => 'manage_pages', 'description' => 'CRUD halaman'],
            ['name' => 'Manage Settings', 'slug' => 'manage_settings', 'description' => 'Edit semua settings'],
            ['name' => 'Manage Menus', 'slug' => 'manage_menus', 'description' => 'CRUD & drag-drop menu'],
            ['name' => 'Manage Sliders', 'slug' => 'manage_sliders', 'description' => 'CRUD slider homepage'],
            ['name' => 'Manage Galleries', 'slug' => 'manage_galleries', 'description' => 'CRUD galeri'],
            ['name' => 'Manage Partners', 'slug' => 'manage_partners', 'description' => 'CRUD partner'],
            ['name' => 'Manage Sponsors', 'slug' => 'manage_sponsors', 'description' => 'CRUD sponsor'],
            ['name' => 'Manage Categories', 'slug' => 'manage_categories', 'description' => 'CRUD kategori'],
        ];

        DB::table('permissions')->insert($permissions);

        $rolePermissions = [
            'super-admin' => array_column($permissions, 'slug'),
            'admin' => ['manage_news', 'manage_pages', 'manage_settings', 'manage_menus', 'manage_sliders', 'manage_galleries', 'manage_partners', 'manage_sponsors', 'manage_categories', 'manage_users'],
            'validator' => ['validate_umkm', 'validate_products', 'manage_own_profile'],
            'umkm-ikm' => ['manage_own_products', 'manage_own_profile'],
            'guest' => [],
        ];

        foreach ($rolePermissions as $roleSlug => $perms) {
            $role = DB::table('roles')->where('slug', $roleSlug)->first();
            if ($role) {
                foreach ($perms as $permSlug) {
                    $perm = DB::table('permissions')->where('slug', $permSlug)->first();
                    if ($perm) {
                        DB::table('role_permissions')->insert([
                            'role_id' => $role->id,
                            'permission_id' => $perm->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
