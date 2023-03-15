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
        // if($user->admin_bool==1){
            // if(Auth::user()->admin_bool!==1){
            //     return redirect()->to(app('url'))->previous()
            //         ->withErrors('一般ユーザーは帰れ');
            // } 
            return redirect()->action('WebappController@index');
        // }
    }
    public function send_mail(Request $request){
        Mail::from($_ENV['MAIL_FROM_ADDRESS'])->to($request->to)->send(new Webapp());
        return redirect('/home');
    }
}
