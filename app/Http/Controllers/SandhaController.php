<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Sandha;
use Exception;

use DB;

class SandhaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sandhas = Sandha::all();
        return view('content.sandha.index', compact('sandhas'));
    }

    public function create()
    {
        return view('content.sandha.newcustomer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sandha_name' => 'required|string|max:255',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            /* 'status' => 'required|in:active,inactive', */
            'description' => 'nullable|string',
            /* 'added_by' => 'required|integer', */
            'no_of_copies' => 'required|integer',
        ]);

        Sandha::create($request->all());
        return redirect()->route('sandhas.index')->with('success', 'Sandha created successfully.');
    }

    public function show(Sandha $sandha)
    {
        return view('sandhas.show', compact('sandha'));
    }

    public function edit(Sandha $sandha)
    {
        return view('content.sandha.edit', compact('sandha'));
    }

    public function update(Request $request, Sandha $sandha)
    {
        $request->validate([
            'sandha_name' => 'required|string|max:255',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $sandha->update($request->all());
        //return redirect()->route('sandhas.index')->with('success', 'Sandha updated successfully.');
        return response()->json(['success' => true, 'message' => 'Sandha status updated to Inactive.']);
    }

    public function destroy(Sandha $sandha)
    {
        $sandha->delete();
        return redirect()->route('sandhas.index')->with('success', 'Sandha deleted successfully.');
    }

    public function softDelete($id)
    {
        $sandha = Sandha::find($id);

        if ($sandha) {
            $sandha->status = 'inactive';
            // $user->deleted_at = now();
            $sandha->save();

            return response()->json(['success' => true, 'message' => 'Sandha status updated to Inactive.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Sandha not found.'], 404);
        }
    }


    // Reminder Sandha

    public function sandhas_reminder(Request $request)
    {
        $unpaidCustomers = []; // Default empty array

        try {
            // Enable query logging for debugging
            DB::enableQueryLog();

            // Raw SQL query as a string
            $query = "
                SELECT customers.*, sandhas.sandha_name, sandhas.duration
                FROM `customers`
                LEFT JOIN `sandhas` ON `sandhas`.`id` = `customers`.`sandha_plan`
                WHERE `customers`.`status` = 'active'
                AND EXISTS (
                    SELECT *
                    FROM `sandhas`
                    WHERE `sandhas`.`id` = `customers`.`sandha_plan`
                        AND DATE_ADD(customers.join_date, INTERVAL sandhas.duration MONTH) <= CURDATE()
                )
                AND NOT EXISTS (
                    SELECT *
                    FROM `sandha_payments`
                    JOIN `sandhas` ON `sandhas`.`id` = `customers`.`sandha_plan`
                    WHERE `sandha_payments`.`customer_id` = `customers`.`id`
                        AND sandha_payments.payment_date >= DATE_ADD(customers.join_date, INTERVAL (FLOOR((TIMESTAMPDIFF(MONTH, customers.join_date, CURDATE()) / sandhas.duration)) * sandhas.duration) MONTH)
                        AND sandha_payments.payment_date < DATE_ADD(customers.join_date, INTERVAL ((FLOOR((TIMESTAMPDIFF(MONTH, customers.join_date, CURDATE()) / sandhas.duration)) + 1) * sandhas.duration) MONTH)
                )
                ORDER BY `sandha_plan` ASC
            ";

            // Execute the raw query
            $unpaidCustomers = DB::select($query);

            // Log the executed queries for debugging
            \Log::info(DB::getQueryLog());
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching unpaid customers: ' . $e->getMessage());
        }

        // Pass the data to the view
        return view('content.customermanagement.customer_payment', compact('unpaidCustomers'));
    }




}
