<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyData extends Model
{
    public $timestamps = false;
    public static function getData($user_id){
        return self::where('user_id',$user_id);
    }
}
