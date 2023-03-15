<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use App\Mail\RegisterMail; 

class RegisterController extends Controller
{
     // 入力画面表示
     public function index() {
        return view('registers.index');
    }

    // 送信ボタン押下時に呼ばれる
    public function register(Request $request) {
        $name = $request['name'];

    Mail::send(new RegisterMail($name));
    return view('registers.index');
    }
}
