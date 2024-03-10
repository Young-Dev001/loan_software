<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan; // Assuming Loan model exists
use App\Models\Member;
use App\Models\Group;
use App\Models\Product;
use App\Models\LoanPayment;
use App\Models\SubGroup;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    // Display a listing of the loans.
    public function printInvoice(Member $member)
    {
        // Retrieve all groups
        $groups = Group::all();

        // Retrieve all loans for the specific member
        $loans = Loan::where('member_id', $member->id)->get();

        // Retrieve products associated with loans
        $productIds = $loans->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get();

        // Initialize variables for total paid amount and remaining amount
        $totalPaidAmount = 0;
        $remainingAmount = 0;

        // Calculate total paid amount and remaining amount for each loan
        foreach ($loans as $loan) {
            $loanPayments = LoanPayment::where('loan_id', $loan->id)->get();
            $totalPaidAmount += $loanPayments->sum('amount_paid');
            $remainingAmount += $loan->loan_total - $totalPaidAmount;
        }

        return view('admin.loans.invoice', compact('member', 'products', 'groups', 'loans', 'totalPaidAmount','loanPayments', 'remainingAmount'));
    }


    public function generateInvoice(Member $member)
    {
        // Retrieve all loans for the specific member with eager loading of loanPayments
        $loans = Loan::with('loanPayments')->where('member_id', $member->id)->get();

        // Retrieve products associated with loans
        $productIds = $loans->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get();

        // Initialize variables for total paid amount and remaining amount
        $totalPaidAmount = 0;
        $remainingAmount = 0;

        // Calculate total paid amount and remaining amount for each loan
        foreach ($loans as $loan) {
            foreach ($loan->loanPayments as $payment) {
                $totalPaidAmount += $payment->amount_paid;
            }
            $remainingAmount += $loan->loan_total - $totalPaidAmount;
        }

        // Prepare data array to pass to the view
        $data = [
            'member' => $member,
            'loans' => $loans,
            'products' => $products,
            'totalPaidAmount' => $totalPaidAmount,
            'remainingAmount' => $remainingAmount,
            'loanPayments' => $loans->pluck('loanPayments')->flatten(), // Flatten loanPayments from nested collections
        ];

        // Load the invoice view and generate the PDF
        $pdf = PDF::loadView('admin.loans.invoice', $data);
        return $pdf->download('invoice.pdf');
    }

    public function getGroup($memberId) {
        $member = Member::find($memberId); // Retrieve the member by ID
        $groupName = $member->group ? $member->group->name : 'No Group'; // Get the group name if available

        return response()->json(['group_name' => $groupName]); // Return the group name as JSON
    }
    public function Dashboard()
    {
        $totalProducts = Product::count(); // Total number of products
        $totalLoans = Loan::count(); // Total number of Loans
        $totalMembers = Member::count();
        $totalGroups = Group::count();
        return view('admin.loans.dashboard', compact('totalLoans','totalMembers','totalMembers','totalGroups'));
    }

    public function LoanRegistrationForm()
    {
        $loans = Loan::latest()->get();
        return view('admin.loans.registration', compact('totalMembers','totalGroups'));
    }
    public function index()
    {
        $loans = Loan::latest()->get();
        $members = Member::all();
        return view('admin.loans.index', compact('loans','members'));
    }

    // Show the form for creating a new loan.
    public function create()
    {
        // Fetch all members, products, and groups
        $members = Member::all();
        $products = Product::all();
        $sub_groups = SubGroup::all();

        // Fetch the group of the first member if members exist


        // Pass the data to the view
        return view('admin.loans.create', compact('members', 'products', 'sub_groups'));
    }


    // Store a newly created loan in the database.
// Store a newly created loan in the database.
public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'member_id' => 'required',
        'product_id' => 'required',
        'sub_group_id' => 'required',
        'amount' => 'required|numeric',
        'interest_rate' => 'required|numeric',
        'term' => 'required|numeric',
        'start_date' => 'required|date',
        'payment_option' => 'required', // Add validation for payment_option
        'payment_amount' => 'nullable|numeric',
        // Add more validation rules as needed
    ]);
        // Check if the member has any pending or incomplete loans
        $memberId = $request->input('member_id');
        $pendingLoans = Loan::where('member_id', $memberId)
                            ->where('completed', false) // Assuming completed column indicates loan completion status
                            ->count();

        // If the member has pending loans, prevent them from taking a new loan
        if ($pendingLoans > 0) {
            $notification = [
                'message' => 'Member has pending loans. Cannot apply for a new loan.!',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

    // Calculate loan interest
    $amount = $validatedData['amount'];
    $interestRate = $validatedData['interest_rate'];
    $term = $validatedData['term'];
    $loanInterest = ($amount * $interestRate / 100 * $term);
    $loanTotal = ($loanInterest + $amount);

    // Set default value for quantity if not provided
    $quantity = $request->input('quantity', 1); // Default value is '1'


    // Find the product
    $product = Product::find($validatedData['product_id']);

    // Check if the product exists and if the stock is greater than 0
    if ($product && $product->stock > 0) {
        // Create a new Loan instance with the validated data
        $loan = new Loan([
            'member_id' => $validatedData['member_id'],
            'product_id' => $validatedData['product_id'],
            'amount' => $validatedData['amount'],
            'quantity' => $quantity,

            'payment_option' => $validatedData['payment_option'], // Assign payment_option
            'loan_interest' => $loanInterest, // Assign loan interest
            'loan_total' => $loanTotal, // Assign loan total
            'interest_rate' => $validatedData['interest_rate'],
            'payment_amount' => $validatedData['payment_amount'],
            'sub_group_id' => $validatedData['sub_group_id'],
            'term' => $validatedData['term'],
            'description' => $request->input('description'),
            'start_date' => $validatedData['start_date'],
            'approved' => $request->has('approved'),
            'completed' => $request->has('completed'),
            // Add other fields as needed
        ]);

        // Save the loan to the database
        $loan->save();

        // Deduct the stock from the relevant product
        $product->stock -= $quantity;
        $product->save();

        // Check if the stock is less than or equal to 0
        if ($product->stock <= 0) {
            // If stock is less than or equal to 0, create a warning notification
            $notification = [
                'message' => 'Product stock is depleted, No Stock Available!',
                'alert-type' => 'light'
            ];
            // Store the notification in session to display it
            session()->flash('notification', $notification);
        }

        // Success notification for loan creation
        $notification = [
            'message' => 'Loan Application created successfully!',
            'alert-type' => 'success'
        ];

        // Redirect back to the index page with a success message
        return redirect()->route('loans.index')->with($notification);
    } else {
        // Redirect back to the loan creation page with a warning message if stock is depleted
        $notification = [
            'message' => 'Product stock is depleted, No Stock Available!',
            'alert-type' => 'light*'
        ];

        return redirect()->back()->withInput()->with('notification', $notification);
    }
}




    // Show the form for editing the specified loan.
    public function edit(Loan $loan)
    {
        $members = Member::all();
        $products = Product::all();
        $groups = Group::all();

        return view('admin.loans.edit', compact('loan','members', 'products', 'groups'));
    }

    // Update the specified loan in the database.
    public function update(Request $request, Loan $loan)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'product_id' => 'required',
            'interest_rate' => 'required|numeric',
            'term' => 'required|numeric',
            'start_date' => 'required|date',
            'payment_option' => 'required', // Add validation for payment_option
            'payment_amount' => 'nullable|numeric',
            // Add more validation rules as needed
        ]);

        // Calculate loan interest
        $amount = $validatedData['amount'];
        $interestRate = $validatedData['interest_rate'];
        $term = $validatedData['term'];
        $loanInterest = ($amount * $interestRate / 100 * $term);
        $loanTotal = ($loanInterest + $amount);

        // Update the loan instance with the validated data
        $loan->update([
            'amount' => $validatedData['amount'],
            'product_id' => $validatedData['product_id'],
            'interest_rate' => $validatedData['interest_rate'],
            'term' => $validatedData['term'],
            'start_date' => $validatedData['start_date'],
            'loan_interest' => $loanInterest,
            'loan_total' => $loanTotal,
            'payment_option' => $validatedData['payment_option'], // Assign payment_option
            'payment_amount' => $validatedData['payment_amount'],
            'description' => $request->input('description'),
            'approved' => $request->has('approved'),
            'completed' => $request->has('completed'),
            // Update other fields as needed
        ]);

        $notification = [
            'message' => 'Loan updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('loans.index')->with($notification);
    }
    // Show the specified loan.
    public function show($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        // Retrieve necessary data
        $members = Member::where('id', $loan->member_id)->get(); // Assuming member_id is the correct foreign key
        $products = Product::all();
        $loanPayments = LoanPayment::where('loan_id', $loan->id)->get();

        // Calculate total amount paid towards the loan
        $totalPaidAmount = $loanPayments->sum('amount_paid');

        // Calculate remaining amount
        $remainingAmount = $loan->loan_total - $totalPaidAmount;

        // Pass data to the view
        return view('admin.loans.show', compact('loan', 'products', 'members', 'loanPayments', 'remainingAmount', 'totalPaidAmount'));
    }



    // Remove the specified loan from the database.
    public function destroy(Loan $loan)
    {
        try {
            // Find the loan by its ID and delete it
            $loan->delete();

            // Set a success message for notification
            $notification = [
                'message' => 'Loan deleted successfully!',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            // If an exception occurs, set an error message for notification
            $notification = [
                'message' => 'Error deleting loan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        // Redirect back to the index page with the notification
        return redirect()->route('loans.index')->with($notification);
    }
}
