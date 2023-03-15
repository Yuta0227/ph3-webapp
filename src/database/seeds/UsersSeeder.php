<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_param=[
            ['name'=>'yuta','email'=>'yutahonjo@keio.jp','password'=>Hash::make('2884Hyuta'),'admin_bool'=>1],
            ['name'=>'root','email'=>'root@keio.jp','password'=>Hash::make('password'),'admin_bool'=>1],
        ];
        DB::table('users')->insert($admin_param);
        $param=[
            ['name'=>'user1','email'=>'user1@keio.jp','password'=>Hash::make('user1')],
            ['name'=>'user2','email'=>'user2@keio.jp','password'=>Hash::make('user2')],
            ['name'=>'user3','email'=>'user3@keio.jp','password'=>Hash::make('user3')],
            ['name'=>'user4','email'=>'user4@keio.jp','password'=>Hash::make('user4')],
            ['name'=>'user5','email'=>'user5@keio.jp','password'=>Hash::make('user5')],
            ['name'=>'user6','email'=>'user6@keio.jp','password'=>Hash::make('user6')],
            ['name'=>'user7','email'=>'user7@keio.jp','password'=>Hash::make('user7')],
        ];
        DB::table('users')->insert($param);
    }
}
