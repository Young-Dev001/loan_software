<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    const IMAGE_PATH = 'upload/product_images/';

    // Display a listing of the products
    public function dashboard()
    {
        $settings = Setting::all();
        $totalProducts = Product::count(); // Total number of products
        $totalSuppliers = Supplier::count(); // Total number of suppliers
        $totalLoans = Loan::count(); // Total number of Loans
        $totalMembers = Member::count(); // Total number of Members

        // Calculate the total expenditure, income, and profit
        $totalExpenditure = 0;
        $totalIncome = 0;

        $products = Product::all(); // Fetch all products

        foreach ($products as $product) {
            $totalExpenditure += $product->buying_price * $product->stock;
            $totalIncome += $product->selling_price * $product->stock;
        }

        $totalProfit = $totalIncome - $totalExpenditure;

        return view('admin.products.dashboard', compact('totalProducts', 'totalSuppliers', 'totalExpenditure', 'totalIncome', 'totalProfit','totalLoans','totalMembers','settings'));
    }

    public function index()
    {
        $products = Product::latest()->get();
        $suppliers = Supplier::all();
        return view('admin.products.index', compact('products','suppliers'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $products = Product::latest()->get();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('products','suppliers'));
    }

    // Store a newly created product in the database
    public function store(Request $request)
    {
        $data = $this->validateProductRequest($request);

        // Process color data
        $colors = $request->input('colors', []);

        // Convert colors array to JSON for storage
        $data['colors'] = json_encode($colors);

        // Handle image uploads
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path(self::IMAGE_PATH), $filename);
                $images[] = self::IMAGE_PATH . $filename;
            }
        }

        // Save product details...
        if (empty($data['barcode'])) {
            $data['barcode'] = '' . time();
        }
        $data['supplier_id'] = $request->input('supplier_id');
        $product = Product::create($data);

        // Save images associated with the product
        foreach ($images as $imagePath) {
            $product->images()->create(['image_path' => $imagePath]);
        }

        $notification = array(
            'message' => 'Product added successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('products.index')->with($notification);
    }

    // Display the specified product
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        // Fetch the distinct colors from the products table
        $colors = DB::table('products')->distinct()->pluck('colors')->flatten()->unique()->toArray();

        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'suppliers', 'colors'));
    }

    // Update the specified product in the database
    public function update(Request $request, Product $product)
    {
        $data = $this->validateProductRequest($request);
        $data['supplier_id'] = $request->input('supplier_id');

        // Process color data
        $colors = $request->input('colors', []);

        // Convert colors array to JSON for storage
        $data['colors'] = json_encode($colors);

        // Handle image uploads
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path(self::IMAGE_PATH), $filename);
                $images[] = self::IMAGE_PATH . $filename;
            }

            // Delete the old images if they exist
            $product->images()->delete();
        }

        $product->update($data);

        // Save new images associated with the product
        foreach ($images as $imagePath) {
            $product->images()->create(['image_path' => $imagePath]);
        }

        $notification = array(
            'message' => 'Product updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('products.index')->with($notification);
    }
    // Remove the specified product from the database
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        $images = $product->images;

        foreach ($images as $image) {
            $imagePath = public_path($image->image_path);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $image->delete();
        }

        // Delete the product
        $product->delete();

        $notification = array(
            'message' => 'Product deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('products.index')->with($notification);
    }




    // Validate common product request data
    private function validateProductRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'description' => 'required',
            'stock' => 'required|numeric|min:1',
            'buying_price' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'barcode' => 'nullable|string',
        ]);
    }
}
