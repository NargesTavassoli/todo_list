<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory(User::class, 10)->create()->each(function ($user) {
       //     $user->task()->saveMany(factory(Task::class, rand(1, 6))->make());
      //  });

    }
}\App\Models\Article::factory()->count(30)->create();
