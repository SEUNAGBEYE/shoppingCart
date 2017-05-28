<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    //

    public function getSignup(){
    	return view('user.signup');
    }

    public function postSignup(Request $request){
    	// return view('user.signup');

    	$this->validate($request, [
    		'email' => 'email|required|unique:users',
    		'password' => 'required|min:4'
    		]);

    	$user = new User([
    		'email' => $request->input('email'),
    		'password' => bcrypt($request->input('password'))
    		]);

    	$user->save();

    	return redirect()->route('product.index');
    }


    public function getSignin(){
       return view('user.login');
    }

    public function postSignin(Request $request){
        // return view('user.signup');

        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
            ]);
        if(\Session::has('cart')){
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
                // return redirect()->back();
                return redirect()->intended('checkout');
            }
        }else{
            return redirect()->route('user.profile');
        }
        
        // return redirect()->intended('checkout');
    }

    public function getProfile(){
        return view('user.profile');
    }

    public function getLogout(){
        Auth::logout();
        return redirect('/product')->with('message', 'Logged out successful');
    }

}

