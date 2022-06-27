<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StudyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param=[
            ['user_id'=>1,'content_id'=>1,'language_id'=>1,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>2,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>3,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>4,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>5,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>6,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
            ['user_id'=>1,'content_id'=>1,'language_id'=>7,'hours'=>2,'posted_at'=>'2022-06-27 10:10:10'],
        ];
        DB::table('study_data')->insert($param);
    }
}
