<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function account(){
        return view('console.user.account');
    }

    public function update(User $user){
        $data = request()->validate([
            "first"=>"required",
            "last"=>"required",
            "email"=>"required",
            "password"=>"nullable"
        ]);

        $user->first=$data['first'];
        $user->last=$data['last'];
        $user->email=$data['email'];


        if(isset($data['password'])) $user->setPasswordAttribute($data['password']);

        $user->save();


        return redirect('/console/user');
    }
}
