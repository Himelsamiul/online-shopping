<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
   public function index()
{
    $sizes = Size::with('products')->paginate(10); // or any number you prefer
    return view('backend.pages.size.list', compact('sizes'));
}


    public function create()
    {
        return view('backend.pages.size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sizes,name'
        ]);

        Size::create([
            'name' => $request->name
        ]);

        return redirect()->route('sizes.list')->with('success', 'Size added successfully!');
    }
    public function edit($id)
{
    $size = Size::findOrFail($id);
    return view('backend.pages.size.edit', compact('size'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:sizes,name,' . $id,
    ]);

    $size = Size::findOrFail($id);
    $size->name = $request->name;
    $size->save();

    return redirect()->route('sizes.list')->with('success', 'Size updated successfully!');
}

public function destroy($id)
{
    $size = Size::findOrFail($id);
    $size->delete();

    return redirect()->route('sizes.list')->with('success', 'Size deleted successfully!');
}

}
