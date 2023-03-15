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
Route::post('/webapp','WebappController@post')->name('post');
// Route::post('/logout','WebappController@logout')->name('logout');
Route::post('/delete_user','AdminController@delete_user')->name('delete_user');
Route::post('/edit_user','AdminController@edit_user')->name('edit_user');
Route::post('/add_user','AdminController@add_user')->name('add_user');
Route::post('/add_content','AdminController@add_content')->name('add_content');
Route::post('/add_language','AdminController@add_language')->name('add_language');
Route::post('/edit_language','AdminController@edit_language')->name('edit_language');
Route::post('/edit_content','AdminController@edit_content')->name('edit_content');
Route::post('/delete_content','AdminController@delete_content')->name('delete_content');
Route::post('/delete_language','AdminController@delete_language')->name('delete_language');
Route::get('/admin','AdminController@index')->name('admin');
Route::post('/month','WebappController@month');
Route::post('/send_mail',function(Request $request){
    $user=User::where('email',$request->to)->get();
    Mail::to($request->to)->send(new Webapp($request->to,$user->first()->name,$request->title,$request->message));
    return redirect('/home');
});
