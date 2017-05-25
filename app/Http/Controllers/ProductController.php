<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    //
    public $item;
    public $price;
    public $quantity = 0;
    public $total = 0;
    // public $all =array();
    // $all_push($item)
    // public $cart = array(array('name' => 'fanta' , );

    public function addToCart(Request $request, $id)
    {
    	
    	$product = Product::find($id);
        $oldcart = \Session::has('cart') ? \Session::get('cart'):null;
        \Session::flush();
    	$product_name = $product->item;
    	$product_price = $product->price;
    	
	   $cart= new Cart($oldcart);
       $cart->addItem($product, $product->id);

       \Session::put('cart', $cart);
       // dd(\Session::get('cart'));
       return redirect()->back();
       
    }
    
   public function showCart()
   {
   	dd(\Session::get('cart'));
   }

    public function showAllProduct()
    {
    	// dd($this->cart);
    	$quantity = \Session::get('quantity');
    	// $quantity = \Session::put('quantity', 0);;
    	$products = Product::all();
    	// dd($this->cart);
    	return view('product_page', compact('products', 'quantity'));

    }
}
