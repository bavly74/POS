<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

    }

    public function create($id){
        $client=Client::find($id);
        $categories=Category::with('products')->get();
        return view('dashboard.orders.create',compact('categories','client'));
    }
}
