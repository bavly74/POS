<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::whereHas('client', function ($query) {
            $query->where('name','like','%'.request('search').'%');
        })->paginate(5);
        return view('dashboard.orders.index', compact('orders'));
    }//end of index

    public function create($id){
        $client=Client::find($id);
        $categories=Category::with('products')->get();
        return view('dashboard.orders.create',compact('categories','client'));
    }//end of create

    public function store(Request $request,$id){

        $client=Client::find($id);

        $order=$client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price=0;

        foreach ($request->products as $id=>$quantity){

            $product=Product::find($id);

            $total_price += $product->sale_price * $quantity['quantity'] ;

            $product->update([
                'stock'=>$product->stock - $quantity['quantity'],
            ]);

        }

        $order->update([
            'total_price'=>$total_price,
        ]);

    return redirect()->route('dashboard.orders.index');

    }//end of store

    public function getProductsPerOrder($id){
        $order=Order::find($id);
        $products = $order->products;
        return view('dashboard.orders._products',compact('products','order'));
    }//end of get products

    public function delete($id)
    {
        $order= Order::with('products')->find($id);
        foreach ($order->products as $product){
            $product->update([
                'stock'=>$product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();
        return redirect()->route('dashboard.orders.index')->with('success','Order has been deleted');
    }//end of delete
}
