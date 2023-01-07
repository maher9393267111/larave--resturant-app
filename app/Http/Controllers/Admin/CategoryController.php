<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;



use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
     //   console.log('categories-->', $categories)
        return view('admin.categories.index', compact('categories'));
    }


    
    // GEt : http
   public function create()
   {
       return view('admin.categories.create');
   }


// Create a new Category

public function store(CategoryStoreRequest $request)
{
  //  $image = $request->file('image')->store('/public/categories');
    
  //  Log::channel('stderr')->info('image data--->' , $image);

 $image = $request->file('image')->store('categories', 'public');
 

    
      Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ]);
    




    return to_route('admin.categories.index')->with('success', 'Category created successfully.');
}

// GET
public function edit(Category $category)
{
    return view('admin.categories.edit', compact('category'));
}


public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required'
    ]);
    $image = $category->image;
    if ($request->hasFile('image')) {
        // DELETE Old category Image
        Storage::delete($category->image);
        $image = $request->file('image')->store('public/categories');
    }

    $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $image
    ]);
    return to_route('admin.categories.index')->with('success', 'Category updated successfully.');
}




}
