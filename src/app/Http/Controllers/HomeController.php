<?php

namespace App\Http\Controllers;

use App\Mail\Webapp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=Auth::user();  
        session(['user'=>$user]);
        session(['year'=>date('Y')]);
        session(['month'=>date('m')]);
        if($user->admin_bool==1){
            $users_list=User::where('admin_bool',0)->get();
            return view('home',compact('user','users_list'));
        }else{
            return redirect()->action('WebappController@index');
        }
    }
    public function send_mail(Request $request){
        Mail::from($_ENV['MAIL_FROM_ADDRESS'])->to($request->to)->send(new Webapp());
        return redirect('/home');
    }
}
