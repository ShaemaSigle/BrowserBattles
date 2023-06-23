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

        Enemy::create(['name' => 'Eater', 'strength'=>'696', 'icon_name'=>'eater.png']);
        Enemy::create(['name' => 'Xenomorph', 'strength'=>'9999', 'icon_name'=>'xenomorph.png']);
        Enemy::create(['name' => 'Blob', 'strength'=>'10', 'icon_name'=>'blob.png']);
        Enemy::create(['name' => 'Box..?', 'strength'=>'100', 'icon_name'=>'box.png']);
        Enemy::create(['name' => 'Cacodemon', 'strength'=>'20000', 'icon_name'=>'cacodemon.png']);

        Guild::create(['name' => 'BigSquad', 'owner'=>'2', 'members_amount'=>'3', 'icon_path'=>'box.png','description'=>'This is a very powerful guild','isopen'=>'true']);
        Guild::create(['name' => 'IDK', 'owner'=>'5', 'members_amount'=>'2', 'icon_path'=>'box.png','description'=>'WE RUULE','isopen'=>'true']);
        Guild::create(['name' => 'lol', 'owner'=>'8', 'members_amount'=>'5', 'icon_path'=>'box.jpg','description'=>'lol', 'isopen'=>'false']);

         \App\Models\User::factory(10)->create();
         \App\Models\Character::factory(10)->create();
         //\App\Models\Encounter::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
