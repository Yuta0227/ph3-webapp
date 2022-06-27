<?php

namespace App\Http\Controllers;

use App\StudyData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebappController extends Controller
{
    public function index()
    {
        if(session()->get('user')==null){
            return redirect('/');
        }
        $study_data=StudyData::getData(session()->get('user')->id)->get();
        $hours_today=$this->hours_today();
        $hours_month=$this->hours_month();
        $hours_total=$this->hours_total();
        return view('webapp', compact('study_data','hours_today','hours_month','hours_total'));
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
    public function hours_month(){
        $study_data_month=StudyData::getData(session()->get('user')->id)->whereMonth('posted_at',Carbon::now()->format('m'))->get();
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
    public function logout()
    {
        session()->forget('user');
        Auth::logout();
        return redirect('/');
    }
}
