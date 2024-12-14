<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // this will show product page
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', ['products' => $products]);
    }

    // this will show create product page
    public function create()
    {
        return view('products.create');
    }

    // this will store or insert a product ib db
    public function store(Request $request)
    {
        $rules =
            [
                'name' => 'required|min:5',
                'sku' => 'required|min:3',
                'price' => 'required|numeric',
            ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $Validator = Validator::make($request->all(), $rules);

        if ($Validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($Validator);
        }

////////////////////////////////////////////database/////////////////////////////////////////////////////////////////////////////////////

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            ///save images to product directry
            $image->move(public_path('uploads/products'), $imageName);
            //save image
            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product Added Successfully...................');
    }


    // this will show edit product page
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }


    // this will update product
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $rules =
            [
                'name' => 'required|min:5',
                'sku' => 'required|min:3',
                'price' => 'required|numeric',
            ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }
        $Validator = Validator::make($request->all(), $rules);

        if ($Validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withInput()->withErrors($Validator);
        }
        ////////////////////////////////////////////database/////////////////////////////////////////////////////////////////////////////////////

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            File::delete(public_path('uploads/products/' . $product->image));
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            ///save images to product directry
            $image->move(public_path('uploads/products'), $imageName);
            //save image
            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully...................');
    }


    // this will destroy a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        //delete image
        File::delete(public_path('uploads/products/' . $product->image));
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully...................');
    }
}
