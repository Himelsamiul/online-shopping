<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function unitlist()
{
    $units = Unit::paginate(10); // Use pagination instead of get()
    return view('backend.pages.units.unitlist', compact('units'));
}


    // Show the form to create a new unit
    public function unitcreate()
    {
        return view('backend.pages.units.unitcreate');
    }

    // Store a new unit in the database
    public function unitStore(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Store the unit
        Unit::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // Redirect back to the units list page with success message
        return redirect()->route('units.list')->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function unitedit(Unit $unit)
    {
        return view('backend.pages.units.edit', compact('unit'));
    }

    // Update the unit
    public function unitupdate(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|unique:units,name,' . $unit->id . '|max:255',
            'status' => 'required|boolean',
        ]);
    
        $unit->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    
        // Return with success message to show in the view
        return redirect()->route('units.list')->with('success', 'Unit updated successfully.');
    }
    

    // Delete a unit
    public function unitdelete(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.list')->with('success', 'Unit deleted successfully.');
    }

    // Show unit details
    public function unitshow(Unit $unit)
    {
        return view('backend.pages.units.show', compact('unit'));
    }
}
