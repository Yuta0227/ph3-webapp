<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    const CREATED_AT = null;
    const UPDATED_AT = null;
    public static function get_all_languages()
    {
        return self::get();
    }
    public function study_datas()
    {
        return $this->hasmany(StudyData::class);
    }
    public function add_language($name,$color)
    {
        $all_color = Language::pluck('color_code')->toArray();
        if (in_array($color, $all_color)) {
            return false;
        } else {
            $language = new Language;
            $language->language = $name;
            $language->color_code = $color;
            $language->save();
            return true;
        }
    }
}
