<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::when($request->search,function($q) use($request){
            return $q->where('name','like','%'.$request->search.'%');
        })->paginate(5);
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

        if ($request->image) {
            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = Str::random() . '_' . time() . '.' . $extension;

            $request->file('image')->move(public_path('uploads/products/'), $fileNameToStore);

        Product::create($request->except('image') + ['image' => $fileNameToStore]);
        }else{
            Product::create($request->all());

        }


        return redirect()->back()->with('success','The product added successfully');

    }
    public function edit($id){
        $product=Product::find($id);
        $categories=Category::all();

        return view('dashboard.products.edit',compact('product','categories'));
    }

    public function update(Request $request,$id){
        $rules=[];
        foreach(config('translatable.locales')as $locale){
            $rules+=[$locale.'.name'=>['required',Rule::unique('products','name')->ignore($id)]];
            $rules+=[$locale.'.description'=>['required',Rule::unique('description','name')->ignore($id)]];
        }
        $rules=[
            'category_id'=>'required',
            'sale_price'=>'required|numeric',
            'purchase_price'=>'required|numeric',
            'stock'=>'required|numeric',
        ];
        $request->validate($rules);
        $categ
        if ($request->image){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = Str::random() . '_' . time() . '.' . $extension;
            $request->file('image')->move(public_path('uploads/products/'), $fileNameToStore);
        }
    }



}
