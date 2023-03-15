<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;
    const CREATED_AT = null;
    const UPDATED_AT = null;
    public static function get_all_contents()
    {
        return self::get();
    }
    public function add_content($name, $color)
    {
        $all_color = Content::pluck('color_code')->toArray();
        if (in_array($color, $all_color)) {
            return false;
        } else {
            $content = new Content;
            $content->content = $name;
            $content->color_code = $color;
            $content->save();
            return true;
        }
    }
    public function study_datas(){
        return $this->hasMany(StudyData::class);
    }
}
