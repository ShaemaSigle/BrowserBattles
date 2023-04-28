<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\Guild;
use App\Models\Encounter;
use App\Models\Enemy;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Enemy::create(['name' => 'Pidor', 'strength'=>'696', 'icon_path'=>'D:\Progs\Wamp.NET\sites\pract.assign.dev\resources\images\pidr.png']);
        Enemy::create(['name' => 'Putin', 'strength'=>'9999', 'icon_path'=>'D:\Progs\Wamp.NET\sites\pract.assign.dev\resources\images\putin.png']);
        Enemy::create(['name' => 'Snek', 'strength'=>'1', 'icon_path'=>'D:\Progs\Wamp.NET\sites\pract.assign.dev\resources\images\snek.jpg']);

         \App\Models\User::factory(10)->create();
         \App\Models\Character::factory(10)->create();
         \App\Models\Encounter::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
