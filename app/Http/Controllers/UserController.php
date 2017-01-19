<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
  protected function userForm(){
    return view('registro');
  }
  protected function registrar(Request $data){
    $user=new User();
    $user->name=$data['name'];
    $user->email=$data['email'];
    $user->password=bcrypt($data['password']);
    $user->type_user=$data['type_user'];
    $user->save();
    return redirect('/');
  }

}
