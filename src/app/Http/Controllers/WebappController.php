<?php

namespace App\Http\Controllers;

use App\Language;
use App\StudyData;
use Carbon\Carbon;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class WebappController extends Controller
{
    public function index()
    {
        if(session()->get('user')==null){
            return redirect('/login');
        }
        $year=session()->get('year');
        $month=session()->get('month');
        list($y,$m,$d)=explode('-',date('Y-n-j'));
        $week_number=$this->getWeekNo($y,$m,$d);
        $calender_month=$this->single($month);
        $study_data=StudyData::getData(session()->get('user')->id)->get();
        $hours_today=$this->hours_today();
        $hours_month=$this->hours_month($year,$month);
        $hours_total=$this->hours_total();
        $bargraph_data=$this->bargraph_data($year,$month);
        $hours_language_array=$this->languages();
        $hours_content_array=$this->contents();
        return view('webapp', compact('study_data','hours_today','hours_month','hours_total','bargraph_data','calender_month','week_number','hours_language_array','hours_content_array'));
    }
    public function getWeekNo($y,$m,$d){
        // 曜日。フルスペル形式。SundayからSaturday
        $l = date("l",mktime(0,0,0,$m,$d,$y));
        // 月。フルスペルの文字。January から December
        $f = date("F",mktime(0,0,0,$m,$d,$y));
        // 例えば date("j",strtotime("first Sunday of June 2019")) は 2
        if(date("j",strtotime("first  {$l} of {$f} {$y}"))==$d) return 1;
        if(date("j",strtotime("second {$l} of {$f} {$y}"))==$d) return 2;
        if(date("j",strtotime("third  {$l} of {$f} {$y}"))==$d) return 3;
        if(date("j",strtotime("fourth {$l} of {$f} {$y}"))==$d) return 4;
        if(date("j",strtotime("fifth  {$l} of {$f} {$y}"))==$d) return 5;
        return false;
    }    
    public function hours_today()
    {
        $study_data_today = StudyData::getData(session()->get('user')->id)->whereDate('posted_at',Carbon::today())->get();
        $hours=0;
        foreach($study_data_today as $data){
            $hours=$hours+$data->hours;
        }
        return $hours;
    }
    public function hours_month($year,$month){
        $study_data_month=StudyData::getData(session()->get('user')->id)->whereYear('posted_at',$year)->whereMonth('posted_at',$month)->get();
        $hours=0;
        foreach($study_data_month as $data){
            $hours=$hours+$data->hours;
        }
        return $hours;
    }
    public function hours_total(){
        $study_data_total = StudyData::getData(session()->get('user')->id)->get();
        $hours=0;
        foreach($study_data_total as $data){
            $hours=$hours+$data->hours;
        }
        return $hours;
    }
    public function bargraph_data($year,$month){
        //carbonで月の初日+月の日数をforで回して
        $study_data_array=[];
        for($day=1;$day<=date('t',strtotime($year.'-'.$month.'-'.'01'));$day++){
            $study_data_day=StudyData::getData(session()->get('user')->id)->whereDate('posted_at',$year.'-'.$month.'-'.$this->double($day))->get();
            $count_study_data_day=$study_data_day->count();
            if($count_study_data_day==0){
                $study_data_array=$study_data_array+array($day=>0);
            }else{
                $hours=0;
                foreach($study_data_day as $data){
                    $hours+=$data->hours;
                }
                $study_data_array=$study_data_array+array($day=>$hours);
            }
        }
        return $study_data_array;
    }
    public function logout()
    {
        session()->forget('user');
        Auth::logout();
        return redirect('/');
    }
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
    public function month(Request $request){
        session(['year'=>$request->year]);
        session(['month'=>$this->double($request->month)]);
        return redirect('/webapp');
    }
    public function languages(){
        $language=Language::get();
        $language_number=$language->count();
        $study_data=StudyData::getData(session()->get('user')->id);
        $hours_language_array=[];
        for($language_index=1;$language_index<=$language_number;$language_index++){
            $language_name=$language->find($language_index)->language;
            $language_color=$language->find($language_index)->color_code;
            $hours_language=$study_data->get();
            $hours=0;
            foreach($hours_language as $data){
                if($data->language_id==$language_index){
                    $hours+=$data->hours;
                }
            }
            $hours_language_array[]=array('hours'=>$hours,'color_code'=>$language_color,'language_name'=>$language_name);
        }
        return $hours_language_array;
    }
    public function contents(){
        $content=Content::get();
        $content_number=$content->count();
        $study_data=StudyData::getData(session()->get('user')->id);
        $hours_content_array=[];
        for($content_index=1;$content_index<=$content_number;$content_index++){
            $content_name=$content->find($content_index)->content;
            $content_color=$content->find($content_index)->color_code;
            $hours_content=$study_data->get();
            $hours=0;
            foreach($hours_content as $data){
                if($data->content_id==$content_index){
                    $hours+=$data->hours;
                }
            }
            $hours_content_array[]=array('hours'=>$hours,'color_code'=>$content_color,'content_name'=>$content_name);
        }
        return $hours_content_array;
    }
}
