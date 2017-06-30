<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;

Use App\Order;
use Auth;

use App\Models\Roles;

use App\User;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard(){dd($request);
    	return view('admin.admin');
    }

    public function addAdmin(Request $request){
    	if($request->isMethod('Post')){
    		
    		$this->validate($request, [
    		'email' => 'email|required|unique:users',
    		'password' => 'required|min:4|confirmed'
    		]);

    		$user = new User([
    		'email' => $request->input('email'),
    		'password' => bcrypt($request->input('password')),
            'role_id' => intval($request->input('role_id')),
            'status_id' => intval($request->input('status_id'))
    		]);

    		$user->save();

            return redirect()->route('dashboard');

    	}else{
    		return view('admin.signup');
    	}

    }

    public function login(Request $request){

    	if($request->isMethod('Post')){
    		if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
    			return view('admin.admin');
    		}else{
    			return redirect()->route('product.index');
    		}
    	}else{
    		
    		return view('admin.adminlogin');
    	}

    }


    public function viewAllUser(){
    	$user = User::all();
    }

    public function viewProduct(Request $request, $id){
    	$method = $request->isMethod();

    	switch ($method) {
    		case 'post':
    			Product::find($id);
;
    			$this->validate($request[

    				]);
    			break;

    		case 'delete':
    			Product::find($id);
    			Product::destroy();
    			break;
    		
    		default:
    			$product = Product::all();
    			return view('admin.product_page', compact('products', 'quantity'));
    			break;
    	}

    }

    public function updateProduct($id){
    	$method = $request->isMethod();
    	switch (variable) {
    		case 'post':
    			$product = Product::find($id);
    			$product->item = $request->input('item');
    			$product->price = $request->input('price');

    			$product->save();
    			return redirect()->to('/');
    			break;
    		
    		default:
    			$product = Product::find($id);
    			break;
    	}
    }

    public function ViewOrders(){
    	$orders = Order::all();
    	$orders->transform(function($order, $key) {
        $order->cart =unserialize($order->cart);
        // return $order;
    	});

         return view('admin.admin', ['orders'=> $orders]);
    }
}
