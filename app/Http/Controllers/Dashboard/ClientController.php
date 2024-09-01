<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $client;
    public function __construct(Client $client){
        $this->client = $client;
    }

    public function index(Request $request){

        $clients=$this->client->when($request->search , function($q) use ($request) {
            return $q->where('name','like','%'.$request->search.'%')
                ->orWhere('phone','like','%'.$request->search.'%')
                ->orWhere('address','like','%'.$request->search.'%')
                ;
        })->paginate(5);
        return view('dashboard.clients.index',compact('clients'));

    }

    public function create(){
        return view('dashboard.clients.create');
    }

    public function store(Request $request){
       $request->validate([
         'name'=>'required',
         'address.0'=>'required',
         'phone.0'=>'required',
       ]);

       Client::create($request->all());
       return redirect()->back()->with('message','Client added successfully');
    }

    public function show(){

    }

    public function edit($id){
         $client=$this->client->find($id);
        return view('dashboard.clients.edit',compact('client'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'address.0'=>'required',
            'phone.0'=>'required',
        ]);

        Client::where('id',$id)->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>request('address'),
        ]);

        return redirect()->back()->with('message','Client updated successfully');
    }

    public function destroy(Request $request,$id){
        Client::destroy($id);
        return redirect()->back()->with('message','Client deleted successfully');
    }
}
