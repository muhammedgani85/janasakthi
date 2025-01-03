<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Cities;
use App\Models\Customer;
use App\Models\Pincode;
use App\Models\Sandha;
use App\Models\State;
use App\Models\User;

class CustomerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Get session data for the current user's location and role
        $location = session('user_data')->location;
        $role = session('user_data')->role;

        // Define filter options
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $status = $request->input('status');
        $city_id = $request->input('city');
        $pincode_id = $request->input('pincode');
        $r_name = $request->input('r_name');
        $location_id =$request->input('location_id');

        $city = Cities::where('status', 'Active')->get();
        $states = State::where('status', 'Active')->get();
        $pincode = Pincode::where('status', 'Active')->get();
        $sandhas = Sandha::where('status', 'Active')->get();
       // dd($request->all());

        // Retrieve all branches for the dropdown
        $branches = Branch::all();
        $ref_customer = Customer::all();

        // Initialize the customer query with default filters
        $query = Customer::with('branch', 'customerpincode', 'customercity')
        ->whereBetween('customers.created_at', [$fromDate, $toDate]);

    if ($request->filled('status')) {
        $query->where('customers.status', $request->input('status'));
    }
    if ($request->filled('city')) {
        $query->where('customers.city', $request->input('city'));
    }
    if ($request->filled('pincode')) {
        $query->where('customers.pincode', $request->input('pincode'));
    }
    if ($request->filled('r_name')) {
        $query->where('customers.r_name', $request->input('r_name'));
    }
    if ($request->filled('location_id')) {
        $query->where('customers.location_id', (int)$request->input('location_id'));
    }

    $customers = $query->get();



         return view('content.customermanagement.report.index', compact('customers', 'branches', 'fromDate', 'toDate', 'status', 'location_id','role','city','states','pincode','sandhas','ref_customer'));




        // Pass data to the view

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getCustomerDetails(Request $request)
{
    $customer = Customer::find($request->id);

    if ($customer) {
        return response()->json([
            'r_phone' => $customer->phone_number,
            'r_address' => $customer->communication_address,
        ]);
    }

    return response()->json(['message' => 'Customer not found.'], 404);
}
}
