<?php

namespace App\Http\Controllers;

use App\Language;
use App\StudyData;
use Carbon\Carbon;
use App\Content;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebappController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect('/login');
        }
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $date = Carbon::now()->format('d');
        list($y, $m, $d) = explode('-', date('Y-n-j'));
        $week_number = $this->getWeekNo($y, $m, $d);
        $calender_month = $this->single($month);
        $study_data = StudyData::getData(Auth::id())->get();
        $hours_today = $this->hours_today();
        $hours_month = $this->hours_month($year, $month);
        $hours_total = $this->hours_total();
        $bargraph_data = $this->bargraph_data($year, $month);
        $hours_language_array = $this->languages();
        $hours_content_array = $this->contents();
        $languages = Language::get_all_languages();
        $contents = Content::get_all_contents();
        return view('webapp', compact('date','month','year','languages', 'contents', 'study_data', 'hours_today', 'hours_month', 'hours_total', 'bargraph_data', 'calender_month', 'week_number', 'hours_language_array', 'hours_content_array'));
    }
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'hours' => 'integer | required',
            'languages' => 'required',
            'contents' => 'required'
        ]);
        if ($validator->fails()) {
            return response("failed", 500);
        }
        $content_count = count($request->contents);
        $language_count = count($request->languages);
        foreach ($request->contents as $content) {
            foreach ($request->languages as $language) {
                $study_data = new StudyData;
                $study_data->user_id = Auth::id();
                $study_data->language_id = $language;
                $study_data->content_id = $content;
                $study_data->hours = $request->hours / ($content_count * $language_count);
                $study_data->posted_at = $request->date;
                $study_data->save();
            }
        }
        return response("success", 200);
    }
    public function getWeekNo($y, $m, $d)
    {
        // 曜日。フルスペル形式。SundayからSaturday
        $l = date("l", mktime(0, 0, 0, $m, $d, $y));
        // 月。フルスペルの文字。January から December
        $f = date("F", mktime(0, 0, 0, $m, $d, $y));
        // 例えば date("j",strtotime("first Sunday of June 2019")) は 2
        if (date("j", strtotime("first  {$l} of {$f} {$y}")) == $d) return 1;
        if (date("j", strtotime("second {$l} of {$f} {$y}")) == $d) return 2;
        if (date("j", strtotime("third  {$l} of {$f} {$y}")) == $d) return 3;
        if (date("j", strtotime("fourth {$l} of {$f} {$y}")) == $d) return 4;
        if (date("j", strtotime("fifth  {$l} of {$f} {$y}")) == $d) return 5;
        return false;
    }
    public function hours_today()
    {
        $study_data_today = StudyData::getData(Auth::id())->whereDate('posted_at', Carbon::today())->get();
        $hours = 0;
        foreach ($study_data_today as $data) {
            $hours = $hours + $data->hours;
        }
        return $hours;
    }
    public function hours_month($year, $month)
    {
        $study_data_month = StudyData::getData(Auth::id())->whereYear('posted_at', $year)->whereMonth('posted_at', $month)->get();
        $hours = 0;
        foreach ($study_data_month as $data) {
            $hours = $hours + $data->hours;
        }
        return $hours;
    }
    public function hours_total()
    {
        $study_data_total = StudyData::getData(Auth::id())->get();
        $hours = 0;
        foreach ($study_data_total as $data) {
            $hours = $hours + $data->hours;
        }
        return $hours;
    }
    public function bargraph_data($year, $month)
    {
        //carbonで月の初日+月の日数をforで回して
        $study_data_array = [];
        for ($day = 1; $day <= date('t', strtotime($year . '-' . $month . '-' . '01')); $day++) {
            $study_data_day = StudyData::getData(Auth::id())->whereDate('posted_at', $year . '-' . $month . '-' . $this->double($day))->get();
            $count_study_data_day = $study_data_day->count();
            if ($count_study_data_day == 0) {
                $study_data_array = $study_data_array + array($day => 0);
            } else {
                $hours = 0;
                foreach ($study_data_day as $data) {
                    $hours += $data->hours;
                }
                $study_data_array = $study_data_array + array($day => $hours);
            }
        }
        return $study_data_array;
    }
    // public function logout()
    // {
    //     session()->forget('user');
    //     Auth::logout();
    //     return redirect('/login');
    // }
    public function single($event)
    {
        for ($i = 1; $i <= 9; $i++) {
            if ($event == '0' . $i) {
                //引数が0付きの二桁の場合一桁に直して返す
                return $i;
            }
        }
        return $event;
    }
    public function double($event)
    {
        for ($i = 1; $i <= 9; $i++) {
            if ($event == $i) {
                return '0' . $i;
            }
        }
        return $event;
    }
    public function month(Request $request)
    {
        session(['year' => $request->year]);
        session(['month' => $this->double($request->month)]);
        return redirect('/webapp');
    }
    public function languages()
    {
        $hours_language=Language::withTrashed()->with('study_datas')->whereHas('study_datas',function($query){
            $query->where('user_id','=',Auth::id());
        })->get();
        $hours_language_array=[];
        foreach($hours_language as $language){
            $total_hours_per_language=$language->study_datas->sum('hours');
            $hours_language_array[]=['hours'=>$total_hours_per_language,'color_code'=>$language->color_code,'language_name'=>$language->language];
        }
        return $hours_language_array;
    }
    public function contents()
    {
        $hours_content=Content::withTrashed()->with('study_datas')->whereHas('study_datas',function($query){
            $query->where('user_id','=',Auth::id());
        })->get();
        $hours_content_array=[];
        foreach($hours_content as $content){
            $total_hours_per_content=$content->study_datas->sum('hours');
            $hours_content_array[]=['hours'=>$total_hours_per_content,'color_code'=>$content->color_code,'content_name'=>$content->content];
        }
        return $hours_content_array;
    }
}
