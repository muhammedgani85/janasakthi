<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Sandha;
use Exception;
use Carbon\Carbon;
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


         // Fetch all active customers with their subscription and payment details
    $customers = Customer::with(['subscriptionPlan', 'subscriptionPayments'])
    ->where('status', 'active') // Only consider active customers
    ->get();

$unpaidCustomers = [];

// Loop through all customers and check if they have pending dues
foreach ($customers as $customer) {
$subscriptionPlan = $customer->subscriptionPlan;
if (!$subscriptionPlan) continue; // Skip customers without a subscription plan

$joinDate = Carbon::parse($customer->join_date);
$nextDueDate = $joinDate->copy();
$payments = $customer->subscriptionPayments;

// Array to hold pending dues for this specific customer
$pendingDues = [];

// Calculate due dates and check if any payment is missing
for ($i = 1; $i <= 12; $i++) { // Example: Check for the next 12 months
$nextDueDate->addMonths($subscriptionPlan->duration);

// Check if payment was made for this period
$payment = $payments->firstWhere(function ($payment) use ($nextDueDate) {
return Carbon::parse($payment->payment_date)->between(
$nextDueDate->copy()->subMonths($subscriptionPlan->duration),
$nextDueDate
);
});

if (!$payment) {
// Add this unpaid due to the list
$pendingDues[] = [
'due_date' => $nextDueDate->format('Y-m-d'),
'amount_due' => $subscriptionPlan->price,
];
}
}

// If there are any pending dues for this customer, add them to the list
if (!empty($pendingDues)) {
$unpaidCustomers[] = [
'customer' => $customer,
'pending_dues' => $pendingDues,
];
}
}

dd($unpaidCustomers);



        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching unpaid customers: ' . $e->getMessage());
        }

        // Pass the data to the view

       // return view('content.customermanagement.customer_payment', compact('unpaidCustomers'));
    }




}
