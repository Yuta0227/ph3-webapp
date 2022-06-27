<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param=[
            ['language'=>'Javascript'],
            ['language'=>'CSS'],
            ['language'=>'PHP'],
            ['language'=>'HTML'],
            ['language'=>'Laravel'],
            ['language'=>'SQL'],
            ['language'=>'SHELL'],
            ['language'=>'情報システム知識(その他)'],
        ];
        DB::table('languages')->insert($param);
    }
}
