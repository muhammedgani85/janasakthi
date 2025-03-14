<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Cities;
use App\Models\Customer;
use App\Models\District;
use App\Models\Pincode;
use App\Models\Sandha;
use App\Models\State;
use Illuminate\Http\Request;

class CustomerPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

      $location = session('user_data')->location;
        $role = session('user_data')->role;

        // Define filter options
        $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->input('to_date', now()->endOfMonth()->toDateString());
        $status = $request->input('status');
        $city_id = $request->input('city');
        $pincode_id = $request->input('pincode');
        $r_name = $request->input('r_name');
        $location_id =$request->input('location_id') ? $request->input('location_id'):$location;

        $city = Cities::where('status', 'Active')->get();
        $states = State::where('status', 'Active')->get();
        $pincode = Pincode::where('status', 'Active')->orderby('pin_code','ASC')->get();
        $sandhas = Sandha::where('status', 'Active')->get();
        $district = District::where('status','Active')->get();
       // dd($request->all());

        // Retrieve all branches for the dropdown
        $branches = Branch::all();
        $ref_customer = Customer::all();

        // Initialize the customer query with default filters
        $query = Customer::with('branch','customerpincode','customercity')
                        ->whereBetween('created_at', [$fromDate, $toDate]);



        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $status);
        }
        if ($request->filled('city')) {
          $query->where('city', $city_id);
        }
        if ($request->filled('pincode')) {
          $query->where('pincode', $pincode_id);
        }



        if ($request->filled('r_name')) {
          $query->where('r_name', $r_name);
        }
       if ($request->filled('location_id')) {
          $query->where('location_id', $location_id);
        }



        // Fetch filtered results
        $customers = $query->get();

        // If no records found, fetch all customers from the user's branch for the current month
        if ($customers->isEmpty()) {
                $fallbackQuery = Customer::with('branch','customerpincode','customercity')
                ->where('location_id', $location);

                // Apply status filter if provided
                if ($request->filled('status')) {
                $fallbackQuery->where('status', $status);
                }


                // Optional: Uncomment the below line if you want to restrict by date in the fallback query
                // $fallbackQuery->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);

                $customers = $fallbackQuery->get();
        }



//dd($customers);

// Pass data to the view
return view('content.customermanagement.report.customer_print', compact('customers', 'branches', 'fromDate', 'toDate', 'status', 'location_id','role','city','states','pincode','sandhas','ref_customer','district'));






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


    public function print(Request $request)
    {

        $pincode = $request->pincode;
        $district_id = $request->district_id;

        // Fetch customers with the specific pincode
        $customers = Customer::query();
        $customers = Customer::with(['city', 'district','customerpincode']);

        $customers->where('status','Active');


        if (!empty($pincode)) {
        $customers->where('pincode', $pincode);
        }

        if (!empty($district_id)) {
        $customers->where('district_id', $district_id);
        }

        $columns = $request->input('column', 2);

        $customers = $customers->orderBy('id')->get();



        $customersPerPage = $customers->chunk(18); // Group into chunks of 4

        return view('content.customermanagement.print.index', compact('customersPerPage', 'pincode','columns','customers'));
    }
}
