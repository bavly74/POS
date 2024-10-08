<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){

        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');

    }

    public function index(Request $request)
    {
        $users=User::whereRoleIs('admin')->where(function ($query) use ($request) {
                return $query ->when( $request->search , function($q) use ($request) {

                return $q->where('first_name' , 'like' , '%'. $request->search . '%')
                    ->orWhere('last_name' , 'like' , '%'. $request->search . '%');
        });

        })->latest()->paginate(5);



        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {


        try{
//            DB::beginTransaction();
            if ($request->image){
                    $extension=$request->file('image')->getClientOriginalExtension();

                    $fileNameToStore =Str::random().'_'.time().'.'.$extension;

                    $request->file('image')->move(public_path('uploads/users/'), $fileNameToStore);

                    $user=User::create([
                        'first_name'=>$request->first_name,
                        'last_name'=>$request->last_name,
                        'email'=>$request->email,
                        'password'=>bcrypt($request->password),
                        'image'=>$fileNameToStore
                    ]);
                $user->attachRole('admin');
                $user->syncPermissions($request->permissions);
            }
        }catch(\Exception $e){
//            DB::rollBack();

            request()->session()->flash('unsuccessMessage', $e->getMessage());
            return redirect()->back();
        }


        return redirect()->back()->with('success','The user added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, $id)
    {


        $requestedData=$request->except(['image']);

        try{
            $user=User::find($id);
            if($request->input('permissions')){
                $user->syncPermissions($request->permissions);
             }

        if($request->image){
            if ($user->image != 'default.jpg'){
                storage::disk('public_uploads')->delete('users/'.$user->image);
            }
            $extension=$request->file('image')->getClientOriginalExtension();
            $fileNameToStore =Str::random().'_'.time().'.'.$extension;
            $request->file('image')->move(public_path('uploads/users/'), $fileNameToStore);
            $requestedData['image']=$fileNameToStore;
        }
            $user->update($requestedData);
            return redirect()->back()->with('success','The user added successfully');

        }catch(\Exception $e){
            request()->session()->flash('unsuccessMessage', $e->getMessage());
            return redirect()->back();
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request,$id)
    {
       $user= User::find($id);
       if ($user->image){
           storage::disk('public_uploads')->delete('users/'.$user->image);
       }
        $user->delete();
        return redirect()->back()->with('success','The user deleted successfully');

    }

}
