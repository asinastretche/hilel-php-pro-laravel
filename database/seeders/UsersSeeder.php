<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        User::factory()->admin()->create([
            'name'=> 'anastasiia',
            'lastname'=> 'admin',
            'email' => 'admin@admin.com',
            'password' =>'12345678',
            'phone' => '380972541476',
            'birthday'=> '01.01.2004'
        ]);
        User::factory()->moderator()->create();
        User::factory(5)->create();
    }
}
