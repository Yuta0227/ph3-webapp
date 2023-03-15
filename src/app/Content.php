<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    const CREATED_AT=null;
    const UPDATED_AT=null;
    public static function get_all_contents(){
        return self::get();
    }
}
