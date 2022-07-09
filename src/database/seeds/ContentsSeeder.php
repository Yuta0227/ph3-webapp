<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param=[
            ['id'=>1,'color_code'=>'#0345EC','content'=>'POSSE課題'],
            ['id'=>2,'color_code'=>'#0F71BD','content'=>'ドットインストール'],
            ['id'=>3,'color_code'=>'#20BDDE','content'=>'N予備校'],
        ];
        DB::table('contents')->insert($param);
    }
}
