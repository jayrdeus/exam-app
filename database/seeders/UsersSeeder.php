<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'name'=> 'Stewie Griffin',
            'email' => 'stewie@mail.com',
            'password' => bcrypt('familyguy'),
        ])->roles()->attach([1,3]);
    }
}
