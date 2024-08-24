<?php

namespace App\Http\Controllers\Dashboard;
use Astrotomic\Translatable\Translatable;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_update'])->only('edit');
    }

    public function index(Request $request)
    {
            $categories = Category::when($request->search,function ($q) use ($request) {
               return $q->where('name' , 'like' , '%'. $request->search . '%');
            })->paginate(5);


            return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rules=[];
        foreach (config('translatable.locales') as $locale) {
            $rules+=[$locale . '.name' => 'required|unique:category_translations,name,'.$locale];
        }
        $request->validate($rules);

        Category::create($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::find($id);

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules=[];
        foreach (config('translatable.locales') as $locale) {
            $rules+=[$locale . '.name' => 'required|unique:category_translations,name,'.$locale];
        }
        $request->validate($rules);
        $data = $request->except(['_token', '_method']);

   return     Category::where('id',$id)->first();

        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
    }
}
