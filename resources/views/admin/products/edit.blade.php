@extends('admin.dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                            <li class="breadcrumb-item active">{{ $product->name }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-8">
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                </div>
                                <input type="text" name="barcode" class="form-control" placeholder="barcode"
                                    value="{{ $product->barcode }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Products Name</label>
                                <input type="text" name="name" class="form-control" id=""
                                    value="{{ $product->name }}" placeholder="e.g Chair, Bed">
                                @error('name')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control"
                                    rows="3">{{ $product->description }}</textarea>
                                @error('description')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="supplier">Supplier</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select select2" id="supplier" name="supplier_id" data-placeholder="Select a supplier">
                                        <option value="" disabled>Select a supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ $supplier->id == $product->supplier_id ? 'selected' : '' }}
                                                class="{{ $supplier->id == $product->supplier_id ? 'selected-supplier' : '' }}">
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" name="stock" value="{{ $product->stock }}"
                                    class="form-control" id="">
                                @error('stock')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Buying Price</label>
                                <div class="input-group mb-3">
                                    <input type="number" min="1" name="buying_price" class="form-control"
                                        value="{{ $product->buying_price }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                @error('buying_price')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Selling Price</label>
                                <div class="input-group mb-3">
                                    <input type="number" min="1" name="selling_price" class="form-control"
                                        value="{{ $product->selling_price }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                @error('selling_price')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="colors">Colors</label><br>
                                @foreach(['black', 'blue', 'red', 'yellow', 'green', 'purple', 'orange', 'pink'] as $color)
                                    <div class="icheck-{{ $color }} d-inline">
                                        <input type="checkbox" id="checkbox{{ $color }}" name="colors[]" value="{{ $color }}"
                                            {{ in_array($color, json_decode($product->colors)) ? 'checked' : '' }}>
                                        <label for="checkbox{{ $color }}">{{ ucfirst($color) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="customFileLabel">Product Images</label>
                                <div class="form-control-wrap">
                                    <div id="carouselExampleCaption" class="carousel slide pointer-event" data-bs-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            @foreach($product->images as $key => $image)
                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image_path) }}" alt="..." class="d-block img-fluid">
                                            </div>
                                            @endforeach
                                        <a class="carousel-control-prev" href="#carouselExampleCaption" role="button" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleCaption" role="button" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                    <div class="custom-file mt-3">
                                        <input type="file" class="custom-file-input" id="customFile" name="images[]" multiple>
                                        <label class="custom-file-label" for="customFile">Choose files</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="hidden" name="status" value="{{ $product->status ? 1 : 0 }}">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3"
                                        {{ $product->status ? 'checked' : '' }} onchange="updateStatus()">
                                    <label class="custom-control-label" for="customSwitch3">Active</label>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    updateStatus(); // Update switch label on page load
                                });

                                function updateStatus() {
                                    var switchCheckbox = document.getElementById('customSwitch3');
                                    var switchLabel = document.querySelector('[for="customSwitch3"]');
                                    var statusInput = document.getElementsByName('status')[0];

                                    if (switchCheckbox.checked) {
                                        switchLabel.textContent = 'Active';
                                        statusInput.value = 1;
                                        // You can add additional logic or actions based on the 'active' state
                                    } else {
                                        switchLabel.textContent = 'Inactive';
                                        statusInput.value = 0;
                                        // You can add additional logic or actions based on the 'inactive' state
                                    }
                                }
                            </script>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success swalDefaultSuccess">Update</button>

                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection
