<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanPayment;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Product;

class LoanPaymentController extends Controller
{
    public function index()
    {
        $loanPayments = LoanPayment::latest()->get();
        return view('admin.loan.payments.index', compact('loanPayments'));
    }

    public function create()
    {
        $members = Member::all();
        $loans = Loan::all();
        $products = Product::all();
        return view('admin.loan.payments.create', compact('members', 'loans', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_method' => 'required',
            'transaction_id' => $request->payment_method === 'mpesa' ? 'required_if:payment_method,mpesa' : '',
            'cheque_no' => $request->payment_method === 'cheque' ? 'required_if|unique:payment_method,cheque' : '',
            'loan_id' => 'required'
        ]);
        // Check if there are payments with the same amount currently being processed
        $existingPayments = LoanPayment::where('amount_paid', $request->amount_paid)
        ->where('created_at', '>=', now()->subSeconds(5)) // Adjust the time window as needed
        ->exists();

        if ($existingPayments) {
        // Delay the current request and display an error message
        sleep(5); // Delay for 5 seconds
        $notification = [
        'message' => 'The other payment is still processing. Please wait and try again.',
        'alert-type' => 'error'
        ];
        return back()->with($notification);
        }

        $loanPayment = new LoanPayment();
        $loanPayment->member_id = $request->member_id;
        $loanPayment->amount_paid = $request->amount_paid;
        $loanPayment->payment_date = $request->payment_date;
        $loanPayment->payment_method = $request->payment_method;

        if ($request->payment_method === 'mpesa') {
            $loanPayment->transaction_id = $request->transaction_id;
        }

        if ($request->payment_method === 'cheque') {
            $loanPayment->cheque_no = $request->cheque_no;
        }

        $loanPayment->loan_id = $request->loan_id;
        $loanPayment->save();

        $notification = [
            'message' => 'Loan payment has been recorded successfully!',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }
    public function edit(LoanPayment $loanPayment)
    {
        $members = Member::all();
        $loans = Loan::all(); // Fetch all loans
        $products = Product::all();
        $loan = Loan::findOrFail($loanPayment->loan_id); // Fetch the associated loan
        return view('admin.loans.edit', compact('loanPayment', 'members', 'loans', 'products', 'loan'));
    }
    


    public function update(Request $request, LoanPayment $loanPayment)
    {
        $validatedData = $request->validate([
            'amount_paid' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);
    
        // Update other fields
        $loanPayment->amount_paid = $request->amount_paid;
        $loanPayment->payment_date = $request->payment_date;
    
        // Update transaction_id if payment_method is mpesa
        if ($request->payment_method === 'mpesa') {
            $validatedData = $request->validate([
                'transaction_id' => 'required',
            ]);
            $loanPayment->transaction_id = $request->transaction_id;
        }
    
        // Update cheque_no if payment_method is cheque
        if ($request->payment_method === 'cheque') {
            $validatedData = $request->validate([
                'cheque_no' => 'required',
            ]);
            $loanPayment->cheque_no = $request->cheque_no;
        }
    
        // Save the changes
        $loanPayment->save();
    
        // Redirect back to the loan page
        $loanId = $loanPayment->loan_id;
        $notification = [
            'message' => 'Loan payment has been updated successfully!',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('loans.show', ['loan' => $loanId])->with($notification);
    }
    
    

    public function show($id)
    {
        $loanPayment = LoanPayment::findOrFail($id);
        $members = Member::all();
        $loans = Loan::all();
        $products = Product::all();
        return view('admin.loan.payments.show', compact('loanPayment', 'members', 'loans', 'products'));
    }

    public function destroy($id)
    {
        $loanPayment = LoanPayment::findOrFail($id);
        $loanPayment->delete();
        
        $notification = [
            'message' => 'Loan payment has been deleted successfully!',
            'alert-type' => 'success'
        ];
    
        return back()->with($notification);
    }
}
