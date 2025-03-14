<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;

class PinCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

     // $pin_codes = Pincode::all();
      $pin_codes = Pincode::with(['addedByUser', 'updatedByUser'])->get();
      return view('content.pincode.index',compact('pin_codes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('content.pincode.newcustomer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'pin_code' => 'required|integer',
    ]);

    // Check if the record already exists
    $exists = Pincode::where('pin_code', $request->pin_code)
                     ->where('name', $request->name)
                     ->exists();
   // dd($exists);
    if ($exists) {
      return response()->json([
        'success' => false,
        'message' => 'This Pincode with the given name already exists.'
    ], 201); // HTTP 422 for validation errors
    }else{


    Pincode::create($request->all());

    return response()->json([
      'success' => true,
      'message' => 'Pincode created successfully.',

  ], 201);
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pincode $pincode)
    {
      return view('content.pincode.edit', compact('pincode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pincode $pincode)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'pin_code' => 'required|integer',
      ]);

      $pincode->update($request->all());
    //return redirect()->route('sandhas.index')->with('success', 'Sandha updated successfully.');
    return response()->json(['success' => true, 'message' => 'Sandha status updated to Inactive.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function softDelete($id)
    {
        $sandha = Pincode::find($id);

        if ($sandha) {
            $sandha->status = 'InActive';
            // $user->deleted_at = now();
            $sandha->save();

            return response()->json(['success' => true, 'message' => 'Pincode status updated to Inactive.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Pincode not found.'], 404);
        }
    }


    public function get_pincode(Request $request){

        $pincode = $request->query('pincode');

        // Fetch matching records from the database
        $data = Pincode::where('pin_code', 'LIKE', "%$pincode%")->get();

        return response()->json($data);

    }





}
