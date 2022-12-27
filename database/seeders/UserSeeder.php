<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role_id' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'role_id' => 3
        ]);
        \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'role_id' => 2
        ]);
        User::factory(50)->create();
    }
}
