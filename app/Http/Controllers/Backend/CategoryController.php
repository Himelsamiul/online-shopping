<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function list(Request $request)
{
    $query = Category::query();

    // Search by category name (Dropdown)
    if ($request->has('search') && $request->search != '') {
        $query->where('name', $request->search); // Exact match for dropdown selection
    }

    // Filter by Status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Paginate 
    $categories = $query->paginate(3);
    $allCategories = Category::all(); // Fetch all categories for dropdown

    return view('backend.pages.categories.list', compact('categories', 'allCategories'));
}







    //form show korbe
    public function create()
    {
        return view('backend.pages.categories.create');
    }





    //store korbe
    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'status' => 'required|in:active,inactive',  // Ensure status is either active or inactive
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);

        // image handel korbe
        $fileName = '';
        if ($request->hasFile('image')) {
            // Generate the file name (timestamp + original extension)
            $fileName = $request->file('image')->getClientOriginalName();
        
            $request->file('image')->storeAs('image/category', $fileName, 'public');
        }
        
        
               
                Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'image' => $fileName,  // Save the generated image file name
                ]);
        
        return redirect()->route('categories.list')->with('success', 'Category created successfully.');
    }





    //crud er edit er kaj 
    public function edit($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Return the edit view with the category data
        return view('backend.pages.categories.edit', compact('category'));
    }





    //update kore submit korkam ,mane edit kore submit korlam ba updagte jeta dhori na jeno same e
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'status' => 'required|in:active,inactive', // Ensure status is either active or inactive
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);

        
        $category = Category::findOrFail($id);

       //image handel korlam
        $fileName = '';
if ($request->hasFile('image')) {
    
    $fileName = $request->file('image')->getClientOriginalName();

    
    $request->file('image')->storeAs('image/category', $fileName, 'public');
}
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $fileName,  // Save the generated image file name
        ]);

        return redirect()->route('categories.list')->with('success', 'Category created successfully.');
    }


    // category er details dekhlam
    public function show($id)
    {
        
        $category = Category::findOrFail($id);

        
        return view('backend.pages.categories.show', compact('category'));
    }

    
    //delete korlam
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete('app/image/category/' . $category->image);
        }
        $category->delete();

        return redirect()->route('categories.list')->with('success', 'Category deleted successfully.');
    }

    
}