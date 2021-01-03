<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Cart;
use Auth;
use Session;
use Validator;
use DB;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }
    public function cart()
    {
        return view('cart');
    }
    public function addToCart($id)
    {
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->photo
                    ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        
        $userDetails = User::find($user_id);
        $countries = Country::get();

        //Check if Shipping Address exists
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        // Update cart table with user email
        $session_id = Session::get('session_id');
        //DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        return view('checkout')->with(compact('userDetails','countries','shippingDetails'));
    }

    public function createCheckout(Request $request){        
        $user_id = Auth::user()->id;
        $data = $request->all();
        $user_email = Auth::user()->email;
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $validator = Validator::make($request->all(), [
            //billing
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_country' => 'required',
            'billing_pincode' => 'required|string|max:25',
            'billing_mobile' => 'required|string|max:255',
            //shipping
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_country' => 'required',
            'shipping_pincode' => 'required|string|max:25',
            'shipping_mobile' => 'required|string|max:255'
        ]);
        if ($validator->passes()) {
            //return response()->json(['success'=>'Added new records.']);  
            $products = Product::all();
            if($shippingCount>0){
                // Update Shipping Address
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);  
            }else{
                // Add New Shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->country = $data['shipping_country'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();              
            }
            // Add Product to the cart
            // $currentCart = session()->get('cart');
            // $cart = new Cart;
            // $cart->user_id = $user_id;
            // $cart->product_id = $user_id;

            // create new task
            // $rows = $request->input('rows');
            // foreach ($rows as $row)
            // {
            //     $Charges[] = new Cart(array(
            //         'user_id'=>,
            //         'Title'=>$row['Title'],
            //         'Quantity'=>$row['Quantity'],
            //         'Price'=>$row['Price'],

            //     ));
            // }
            // Cart::create($Charges);


            // Add New Billing entry
            // $billing = new BillingAddress;
            // $billing->user_id = $user_id;
            // $billing->user_email = $user_email;
            // $billing->name = $data['shipping_name'];
            // $billing->address = $data['shipping_address'];
            // $billing->city = $data['shipping_city'];
            // $billing->state = $data['shipping_state'];
            // $billing->pincode = $data['shipping_pincode'];
            // $billing->country = $data['shipping_country'];
            // $billing->mobile = $data['shipping_mobile'];
            // $billing->save();

        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
}