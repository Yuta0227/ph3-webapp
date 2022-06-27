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
            ['content'=>'POSSE課題'],
            ['content'=>'ドットインストール'],
            ['content'=>'N予備校'],
        ];
        DB::table('contents')->insert($param);
    }
}
