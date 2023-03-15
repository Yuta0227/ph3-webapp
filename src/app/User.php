<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $table='users';
    protected $fillable = [
        'id','name', 'email', 'password','admin_bool'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function add_user($name,$email,$password,$admin_bool){
        $all_email_address=User::pluck('email')->toArray();
        if(in_array($email,$all_email_address)){
            return false;
        }
        $user=new User;
        $user->name=$name;
        $user->email=$email;
        $user->password=Hash::make($password);
        $user->admin_bool=$admin_bool;
        $user->save();
        return true;
    }
    public function study_datas(){
        return $this->hasMany(StudyData::class);
    }
}
