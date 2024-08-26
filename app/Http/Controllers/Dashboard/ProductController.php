<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::when($request->search,function($q) use($request){
            return $q->where('name','like','%'.$request->search.'%');
        });
        return view('dashboard.products.index', compact('products'));
    }

    public function  create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    public function store(Request $request){


        $rules=[];
        foreach (config('translatable.locales') as $locale) {
            $rules+=[$locale.'.name'=>'required'];
            $rules+=[$locale.'.description'=>'required'];
        }
        $rules=[
            'category_id'=>'required',
            'sale_price'=>'required|numeric',
            'purchase_price'=>'required|numeric',
            'stock'=>'required|numeric',
        ];

        $request->validate($rules);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = Str::random() . '_' . time() . '.' . $extension;

            $request->file('image')->move(public_path('uploads/products/'), $fileNameToStore);

//           return $product = Product::create($request->except('image') + ['image' => $fileNameToStore]);
        }

        Product::create($request->all());

        return redirect()->back()->with('success','The product added successfully');

    }



}
