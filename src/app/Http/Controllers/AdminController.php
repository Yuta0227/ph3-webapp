<?php

namespace App\Http\Controllers;

use App\Content;
use App\Language;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        if(Auth::user()->admin_bool!==1){
            return back()->with('error','管理者になってから来い');
        }
        $all_users=User::where('admin_bool',0)->get();
        $all_contents=Content::get();
        $all_languages=Language::get();
        return view('admin',compact('all_users','all_contents','all_languages'));
    }
    public function delete_user(Request $request){
        User::find($request->id)->delete();
        return redirect()->back();
    }
    public function delete_content(Request $request){
        Content::find($request->id)->delete();
        return redirect()->back();
    }
    public function delete_language(Request $request){
        Language::find($request->id)->delete();
        return redirect()->back();
    }
    public function edit_user(Request $request){
        $user=User::find($request->id);
        $user->name=$request->name;
        $user->save();
        return redirect()->back();
    }
    public function add_user(Request $request){
        $user=new User;
        $result=$user->add_user($request->name,$request->email,$request->password,$request->admin_bool);
        if($result){
            return redirect()->back();
        }else{
            return redirect()->back()->with('error','すでに存在するメールアドレス');
        }
    }
    public function add_content(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => ['required',
            'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',]
        ]);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        $content=new Content;
        $result=$content->add_content($request->name,$request->color);
        if($result){
            return redirect()->back();
        }else{
            return redirect()->back()->with('error','すでに存在するコンテンツ色');
        }
    }
    public function add_language(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => ['required',
            'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',]
        ]);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        $language=new Language;
        $result=$language->add_language($request->name,$request->color);
        if($result){
            return redirect()->back();
        }else{
            return redirect()->back()->with('error','すでに存在する言語色');
        }
    }
    public function edit_language(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => ['required',
            'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',]
        ]);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        $all_languages=Language::pluck('color_code')->toArray();
        if(in_array($request->color,$all_languages)){
            return redirect()->back()->with('error','すでに存在する言語色');
        }
        $language=Language::find($request->id);
        $language->language=$request->name;
        $language->color_code=$request->color;
        $language->save();
        return redirect()->back();
    }
    public function edit_content(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => ['required',
            'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',]
        ]);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        $all_contents=Content::pluck('color_code')->toArray();
        if(in_array($request->color,$all_contents)){
            return redirect()->back()->with('error','すでに存在するコンテンツ色');
        }
        $content=Content::find($request->id);
        $content->content=$request->name;
        $content->color_code=$request->color;
        $content->save();
        return redirect()->back();
    }
}
