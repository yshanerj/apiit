<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Product;

use App\Models\Category;

use App\Models\Cart;

use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home.userpage');
    }

    public function productpage()
    {
        $product=product::paginate(20);
        return view('home.product.productpage',compact('product'));
    }

    public function cart(Request $request,$id)
    {
        if(Auth::id())
        {
            $user=Auth::user();
            $product=product::find($id);

            $cart =new cart;
            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->street=$user->street;
            $cart->city=$user->city;
            $cart->country=$user->country;
            $cart->user_id=$user->id;

            $cart->product_name=$product->name;
            $cart->price=$product->price * $request->quantity;
            $cart->image=$product->image;
            $cart->product_id=$product->id;
            $cart->quantity=$request->quantity;
            $cart->size=$request->size;

            $cart->save();
            return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
    }

    public function userpage()
    {
        return view('home.home.userpage');
    }

    public function contact()
    {
        return view('home.contact.contact');
    }

    public function productdetail($id)
    {
        $product=product::find($id);
        return view('home.productdetail.productdetail',compact('product'));
    }

    public function about()
    {
        return view('home.about.about');
    }

    public function payment()
    {
        return view('home.payment.payment');
    }

    public function show_cart()
    {
        if(Auth::id())
        {
            $id=Auth::user()->id;
            $cart=cart::where('user_id','=',$id)->get();
            return view('home.cart.show_cart',compact('cart'));
        }
        else
        {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart=cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function order()
    {
        return view('home.order.place_order');
    }

    public function cash_order()
    {
        $user=Auth::user();
        $userid=$user->id;
        $data=cart::where('user_id','=',$userid)->get();

        foreach($data as $data)
        {
            $order=new order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->street=$data->street;
            $order->city=$data->city;
            $order->country=$data->country;
            $order->user_id=$data->user_id;

            $order->product_name=$data->product_name;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->size=$data->size;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='Cash On Delivery';
            $order->delivery_status='Processing';

            $order->save();
            $cart_id=$data->id;
            $cart=cart::find($cart_id);
            $cart->delete();
        }
        return redirect()->back()->with('message','Order Placed Successfully. We Will Contact You Soon!');
    }

    public function card_order()
    {
        $user=Auth::user();
        $userid=$user->id;
        $data=cart::where('user_id','=',$userid)->get();

        foreach($data as $data)
        {
            $order=new order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->street=$data->street;
            $order->city=$data->city;
            $order->country=$data->country;
            $order->user_id=$data->user_id;

            $order->product_name=$data->product_name;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->size=$data->size;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='Card Payment';
            $order->delivery_status='Processing';

            $order->save();
            $cart_id=$data->id;
            $cart=cart::find($cart_id);
            $cart->delete();
        }
        return redirect()->back()->with('message','Order Placed Successfully. We Will Contact You Soon!');
    }

    public function view_order()
    {
        $user=Auth::user();
        $userid=$user->id;
        $order=order::where('user_id','=',$userid)->get();
        return view('home.order.view_order',compact('order'));
    }

    public function cancel_order($id)
    {
        $order=order::find($id);
        $order->delivery_status='Order Cancelled';
        $order->save();
        return redirect()->back();
    }

}


