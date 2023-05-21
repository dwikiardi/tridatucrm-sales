<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
  
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use App\Models\Roles;
  
  
class AuthController extends Controller
{
    public function index(){
        $id=auth()->user()->roleid;
        $roles=Roles::get()->where('id','=',$id);
        return view('home',compact('roles'));
    }
    
    public function login()
    {
        if (Auth::check()) {
            return redirect('home');
        }else{
            return view('auth.login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect('home');
        }else{
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
  
  
}