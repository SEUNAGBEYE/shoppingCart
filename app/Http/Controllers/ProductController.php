<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Cart;
use Stripe\Charge;
use Stripe\Stripe;
Use App\Order;
use Auth;

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
        // \Session::flush();
    	// $product_name = $product->item;
    	// $product_price = $product->price;
    	
	   $cart= new Cart($oldcart);
       $cart->addItem($product, $product->id);

       \Session::put('cart', $cart);
       // dd(\Session::get('cart'));
       \Session::flash('added', '1 item Added');
       return redirect()->back();
       
    }
    
   public function showCart()
   {
   	// dd(\Session::get('cart'));
      if (!\Session::has('cart')){
        return view('shopping-cart', ['products' => null]);
      }
    
     $oldcart = \Session::get('cart');
     $cart = new Cart($oldcart);
     // $id = key($cart->itemsName);
     // $product = $cart->itemsName[$id]['quantity'];
     // dd($cart->itemsName);exit;

     return view('shopping-cart', ['products'=>$cart->itemsName, 'totalPrice'=>$cart->totalPrice]);

 }

    public function showAllProduct()
    {
    	// dd($this->cart);
      // dd(\Request::flash());
    	$quantity = \Session::get('quantity');
    	// $quantity = \Session::put('quantity', 0);;
    	$products = Product::all();
    	// dd($this->cart);
    	return view('product_page', compact('products', 'quantity'));
      

    }

    public function clearCart()
    {
      \Session::flush();
      return redirect('/product');
    }

    public function removeItem($id)
    {
     
     $product = Product::find($id)->first();
        $oldcart = \Session::has('cart') ? \Session::get('cart'):null;
        // $cart = new Car()
        
      $cart= new Cart($oldcart);
      $cart->reduceByOne($product, $product->id);
       return redirect('/product');

       \Session::put('cart', $cart);
       // dd(\Session::get('cart'));
      // return redirect('/product/cart');
    }

    public function removeAllItem(){
      
      $product = Product::find($id)->first();
      $oldcart = \Session::has('cart') ? \Session::get('cart'):null;

       $cart= new Cart($oldcart);
      $cart->reduceByOne($product, $product->id);
    }

    public function getCheckout(){
      // if (!\Session::has('cart')){
      //   return view('shopping-cart', ['products' => null]);
      // } 

       if(!Auth::check()){
            return redirect()->route('user.signin')->with('login', 'Please Login To Continue Payment');
          }

      $oldcart = \Session::get('cart');
      $cart = new Cart($oldcart);
      $total = $cart->totalPrice;
      return view('checkout', ['total' =>$total]);
    }

     public function postCheckout(Request $request){
        if (!\Session::has('cart')){
          return redirect()->route('shopping-cart');
        } 


        $oldcart = \Session::get('cart');
        $cart = new Cart($oldcart);

        Stripe::setApiKey('Sorry cant put my secret key');
        try{
          $charge = Charge::create(array(
            'amount' => $cart->totalPrice,
            'currency' => 'usd',
            'source' => $request->input('stripeToken'), //obtain with Stripe.
            'description' => 'Test Charge'
            ));
          // dd('hi');
         
          $order = new Order();
          $order->cart = serialize($cart);
          $order->address =  $request->input('address');
          $order->payment_id = $charge->id;


          Auth::user()->orders()->save($order);
          
        }catch (\Exception $e){
          return redirect()->route('checkout')->with(['error' => $e->getMessage()]);
        }

        \Session::forget('cart');
        return redirect('/product')->with('success', 'Successfully purchased');
    }
        
}
