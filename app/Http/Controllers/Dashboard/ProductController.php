<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::when($request->search,function($q) use($request){
            return $q->where('name','like','%'.$request->search.'%');
        });
        return view('dashboard.product.index', compact('products'));
    }
}
