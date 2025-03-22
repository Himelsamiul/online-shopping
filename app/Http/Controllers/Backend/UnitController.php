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
        $units = Unit::all(); // Fetch all units from the database
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
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
