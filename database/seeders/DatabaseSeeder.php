<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //TODO: Add seeder for project status
        User::create([
            'name' => "Admin",
            'email' => "admin@example.com",
            "password" => Hash::make('admin123'),
        ]);

        Status::create(['status' => 'todo','user_id'=>null]);
        Status::create(['status' => 'doing','user_id'=>null]);
        Status::create(['status' => 'done','user_id'=>null]);


    }
}
