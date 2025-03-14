<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\District;


class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $districts = District::all();
        return view('content.district.index', compact('districts'));
    }
    public function create()
    {
        return view('districts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required',
            'district_name_tamil' => 'required',
            'state_id' => 'required|integer',
        ]);
        District::create($request->all());
        return redirect()->route('districts.index')->with('success', 'District added successfully');
    }
    public function edit(District $district)
    {
        return view('districts.edit', compact('district'));
    }
    public function update(Request $request, District $district)
    {
        $request->validate([
            'district_name' => 'required',
            'district_name_tamil' => 'required',
            'state_id' => 'required|integer',
        ]);
        $district->update($request->all());
        return redirect()->route('districts.index')->with('success', 'District updated successfully');
    }
    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('districts.index')->with('success', 'District deleted successfully');
    }
}
