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
            ['color_code'=>'#0345EC','language'=>'Javascript'],
            ['color_code'=>'#0F71BD','language'=>'CSS'],
            ['color_code'=>'#20BDDE','language'=>'PHP'],
            ['color_code'=>'#3CCEFE','language'=>'HTML'],
            ['color_code'=>'#B29EF3','language'=>'Laravel'],
            ['color_code'=>'#6D46EC','language'=>'SQL'],
            ['color_code'=>'#4A17EF','language'=>'SHELL'],
            ['color_code'=>'#3105C0','language'=>'情報システム知識(その他)'],
        ];
        DB::table('languages')->insert($param);
    }
}
