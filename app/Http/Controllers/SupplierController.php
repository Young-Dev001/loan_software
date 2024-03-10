<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.suppliers.create', compact('suppliers'));
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:suppliers',
            'phone' => ['required', 'string', 'max:255', 'regex:/^\+254[17]\d{8}$/'],
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => $validator->errors()->all(),
                'alert-type' => 'error'
            );

            return redirect()->back()
                ->withInput()
                ->with($notification);
        }

        Supplier::create($request->all());

        $notification = array(
            'message' => 'Supplier created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('suppliers.index')
            ->with($notification);
    }


    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => ['required', 'string', 'max:255', 'regex:/^\+254[17]\d{8}$/'],
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => $validator->errors()->all(),
                'alert-type' => 'error'
            );

            return redirect()->back()
                ->withInput()
                ->with($notification);
        }

        $supplier->update($request->all());

        $notification = array(
            'message' => 'Supplier updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('suppliers.index')
            ->with($notification);
    }


    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        $notification = array(
            'message' => 'Supplier deleted successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('suppliers.index')
            ->with($notification);
    }
}
