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
        $study_data = StudyData::getData(session()->get('user')->id)->get();
        $hours_today=$this->hours_today();
        return view('webapp', compact('study_data','hours_today'));
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
    public function logout()
    {
        session()->forget('user');
        Auth::logout();
        return redirect('/');
    }
}
