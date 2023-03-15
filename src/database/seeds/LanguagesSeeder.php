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
            ['id'=>1,'color_code'=>'#0345EC','language'=>'Javascript'],
            ['id'=>2,'color_code'=>'#0F71BD','language'=>'CSS'],
            ['id'=>3,'color_code'=>'#20BDDE','language'=>'PHP'],
            ['id'=>4,'color_code'=>'#3CCEFE','language'=>'HTML'],
            ['id'=>5,'color_code'=>'#B29EF3','language'=>'Laravel'],
            ['id'=>6,'color_code'=>'#6D46EC','language'=>'SQL'],
            ['id'=>7,'color_code'=>'#4A17EF','language'=>'SHELL'],
            ['id'=>8,'color_code'=>'#3105C0','language'=>'情報システム知識(その他)'],
        ];
        DB::table('languages')->insert($param);
    }
}
