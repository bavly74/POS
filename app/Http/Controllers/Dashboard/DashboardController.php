<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $products_count = Product::count();
        $categories_count = Category::count();
        $clients_count=Client::count();
        $users_count = User::whereRoleIs('admin')->count();

        return view('dashboard.index',compact('products_count','categories_count','clients_count','users_count'));
    }
}
