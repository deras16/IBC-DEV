<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('name', 'SUPER-ADMIN')->first();
        $marketing = Role::where('name', 'MARKETING')->first();

        User::factory()->create([
            'id' => 1,
            'name' => 'Administrator',
            'email' => 'administrator@example.com',
        ])->assignRole($admin);

        User::factory()->create([
            'id' => 2,
            'name' => 'Test',
            'email' => 'test@example.com'
        ])->assignRole($marketing);
    }
}
