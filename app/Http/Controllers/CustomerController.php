<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Category;

use App\Models\Cart;

use App\Models\Order;

use App\Models\User;

class CustomerController extends Controller
{
    public function customer_data()
    {
        $customer_data=user::all();
        return view('admin.customer_data',compact('customer_data'));
    }

    public function delete_customer($id)
    {

        $customer_data=user::find($id);

        $customer_data->delete();

        return redirect()->back()->with('message', 'Customer Removed Successfully');


    }


}
