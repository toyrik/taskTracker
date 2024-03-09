<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Database\Factories\TaskFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name'    => 'Iam',
            'last_name'     => 'Admin',
            'email'         => 'admin@app.local',
            'username'      => 'admin-01',
            'password'      => Hash::make('12qwaszx'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin'      => 1,
            'created_at'    => now(),
        ]);
        User::create([
            'first_name'    => 'Iam',
            'last_name'     => 'User',
            'email'         => 'user@app.local',
            'username'      => 'user-01',
            'password'      => Hash::make('12qwaszx'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin'      => 0,
            'created_at'    => now(),
        ]);

        Task::factory()->count(10)->create();
    }
}
