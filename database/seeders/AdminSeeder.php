<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = DB::table('roles')->where('slug', 'super-admin')->first();

        if ($role) {
            DB::table('users')->insert([
                'name' => 'Super Admin',
                'email' => 'admin@pupr.go.id',
                'password' => Hash::make('admin123'),
                'phone' => '',
                'role_id' => $role->id,
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}