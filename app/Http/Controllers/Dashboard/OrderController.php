<?php

namespace App\Http\Controllers\Dashboard;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
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
        $categories=Category::with('products')->get();
        $client=Client::find($id);
        $orders= $client->orders()->with('products')->paginate(5);
        return view('dashboard.orders.create',compact('categories','client','orders'));
    }//end of create

    public function store(Request $request,$id){

        $client=Client::find($id);
        $this->attachOrder($request,$client);
        $data = [
            'title' => 'Hello World',
            'message' => 'This is a test email.',
        ];
        Mail::to($client->email)->send(new ExampleMail($data));


        return redirect()->route('dashboard.orders.index');

    }//end of store

    public function getProductsPerOrder($id){
        $order=Order::find($id);
        $products = $order->products;
        return view('dashboard.orders._products',compact('products','order'));
    }//end of get products

    public function edit ($id, $clientId)
    {
        $order=Order::with('client')->find($id);
        $client=Client::find($clientId);
        $orders=$client->orders()->with('products')->paginate(5);
        $categories=Category::with('products')->get();

        return view('dashboard.orders.edit',compact('id','categories','clientId','orders','client','order'));

    }//end of edit


    public function update(Request $request, $orderId , $clientId){
     $client=Client::find($clientId);

     $this->delete($orderId);
     $this->attachOrder($request,$client);

     return redirect()->route('dashboard.orders.index')->with('success','Order updated successfully');
    }//end of update

    private function attachOrder($request,$client)
    {
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

    }//end of attach


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
