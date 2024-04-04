<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Category;

class ProductController extends Controller
{
    public function view_product()
    {
        $category =category::all();
        return view('admin.product',compact('category'));
    }

    public function add_product(Request $request)
    {
        $product=new product;
        $product->name=$request->name;
        $product->description=$request->description;
        $product->category=$request->category;
        $product->size=$request->size;
        $product->quantity=$request->quantity;
        $product->price=$request->price;

        $image=$request->image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);
        $product->image=$imagename;


        $product->save();
        return redirect()->back()->with('message','Product Added Successfully');
    }

    public function show_product()
    {
        $product=product::all();
        return view('admin.show_product',compact('product'));
    }

    public function delete_product($id)
    {
        $product=product::find($id);
        $product->delete();
        return redirect()->back()->with('message','Product Deleted Successfully');;
    }

    public function edit_product($id)
    {
        $product=product::find($id);
        $category=category::all();
        return view('admin.edit_product',compact('product','category'));
    }

    public function edit_product_confirm(Request $request,$id)
    {

        $product=product::find($id);

        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->category=$request->category;
        $product->size=$request->size;
        $product->quantity=$request->quantity;

        $image=$request->image;

        if($image)
        {
            $currentimage=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$currentimage);
            $product->image=$currentimage;
        }

        $product->save();
        return redirect()->back()->with('message','Product Edited Successfully');;
    }
}
