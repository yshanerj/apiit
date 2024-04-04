<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyAnalystController extends Controller
{
    public function company_analyst()
    {
        $total_product=product::all()->count();
        $total_order=order::all()->count();
        $total_user=user::all()->count();
        $order=order::all();
        $total_revenue=0;

        foreach($order as $order)
        {
            $total_revenue=$total_revenue + $order->price;
        }

        $total_delivered=order::where('delivery_status','=','delivered')->get()->count();
        $total_processing=order::where('delivery_status','=','processing')->get()->count();

        return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_delivered','total_processing'));
    }
}
