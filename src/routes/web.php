<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\Webapp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/webapp','WebappController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/webapp','WebappController@index')->name('webapp');
Route::post('/logout','WebappController@logout')->name('logout');
Route::post('/month','WebappController@month');
Route::post('/send_mail',function(Request $request){
    $user=User::where('email',$request->to)->get();
    Mail::to($request->to)->send(new Webapp($request->to,$user->first()->name,$request->title,$request->message));
    return redirect('/home');
});
