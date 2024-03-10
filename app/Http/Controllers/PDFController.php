<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Product;

class PDFController extends Controller
{
    public function generatePDF(Member $member)
    {
        // Retrieve all loans for the specific member
        $loans = Loan::where('member_id', $member->id)->get();

        // Retrieve products associated with loans
        $productIds = $loans->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get();

        $data = [
            'title' => 'Blue-Capital Members',
            'date' => date('m/d/Y'),
            'loans' => $loans, // Pass the loans data to the view
            'member' => $member, // Pass the member data to the view
            'products' => $products, // Pass the products data to the view
        ];

        $pdf = PDF::loadView('admin.loans.registration', $data);
        return $pdf->download('members-lists.pdf');
    }


    
    public function RegistrationForm()
    {
        $members = member::get();

        $data = [
            'title' => 'Blue-Capital Members',
            'date' => date('m/d/Y'),
            'members' => $members
        ];

        $pdf = PDF::loadView('admin.members.registrationForm', $data);
        return $pdf->download('members-lists.pdf');
    }
}
