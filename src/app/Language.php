<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const CREATED_AT=null;
    const UPDATED_AT=null;
    public static function get_all_languages(){
        return self::get();
    }
}
