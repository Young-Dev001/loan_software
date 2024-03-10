@extends('admin.dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Products</h4>
                            <a class="btn btn-outline-primary waves-effect waves-light" href="{{ route('products.create')}}">
                                <i class="fa fa-plus-circle"></i> Add New product
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="selection-datatable" class="table table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Barcode</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Stock</th>
                                        <th>Supplier</th>
                                        <th>Buying price</th>
                                        <th>Selling Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $product->barcode }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" style="font-weight: bold; text-decoration:none;">{{ $product->name }}</a>
                                        </td>
                                        <td>
                                            @if($product->stock <= 0)
                                                <span style="font-weight: bold; color: red;">Out of stock</span>
                                            @elseif($product->stock <= 5)
                                                <span style="font-weight: bold; color: orange;">Running Out Of Stock</span>
                                            @else
                                                <span style="font-weight: bold; color: green;">In-stock</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->stock }} Item(s)</td>
                                        <td>
                                            <a style="font-weight: bold; text-decoration:none;" href="{{ route('suppliers.show', $product->supplier_id) }}">{{ App\Models\Supplier::find($product->supplier_id)->name }}</a>
                                        </td>
                                        <td>Ksh. {{ number_format($product->buying_price, 2) }}</td>
                                        <td>Ksh. {{ number_format($product->selling_price, 2) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> View</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div>
</div>

@endsection
