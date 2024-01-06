<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "parspack",
            "email" => "parspack@parspack.com",
            "password" => Str::ascii(10)// Generates a random alphanumeric string of length 10
        ]);
    }
}
