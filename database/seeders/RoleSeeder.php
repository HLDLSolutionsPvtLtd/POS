<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'terinao',
            'email' => 'terinao86@gmail.com',
            'phone_no' => '8974393643',
            'password' => Hash::make('password'),
        ]);
        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'manager',
        ]);

        Role::create([
            'name' => 'sales',
        ]);

        Role::create([
            'name' => 'customer',
        ]);

        User::find(1)->assignRole('admin');
    }
}
