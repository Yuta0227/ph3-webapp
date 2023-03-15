<?php

namespace App\Http\Composers;  //配置したディレクトリに沿って記述
use Illuminate\View\View; //追記する

class WebappComposer
{

    /**
     * @param View $view
     * @return void
     */

    public function compose(View $view)
    {
        $today_post_calender = now()->format('Y-m-d');
        $view->with(compact('today_post_calender'));
    }
}
