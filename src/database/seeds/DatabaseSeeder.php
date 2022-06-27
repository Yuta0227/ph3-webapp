<?php

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
        $this->call(StudyDataSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(LanguagesSeeder::class);
        $this->call(ContentsSeeder::class);
    }
}
