<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'kimhsiao',
                'email' => 'white.shopping@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'gender' => 1,
                'active' => 1,
                'role' => 2,
                'deleted_at' => null,
            ]);

        User::factory()
            ->count(100)
            ->create();
    }
}
