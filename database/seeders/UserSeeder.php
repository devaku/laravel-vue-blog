<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create three users debug users
        User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@email.com',
            "password"=> "user1"
            ]
        );  
        User::factory()->create([
            'name' => 'user2',
            "password"=> "user2",
            'email' => 'user2@email.com']
        );  
        User::factory()->create([
            'name' => 'user3',
            "password"=> "user3",
            'email' => 'user3@email.com']
        );  
    }
}
