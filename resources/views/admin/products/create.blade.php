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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    </div>
                                    <input type="text" name="barcode" class="form-control" placeholder="barcode">
                                </div>
                                <div class="form-group">
                                    <label>Products Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        placeholder="e.g Chair, Bed">
                                    @error('name')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Enter ...">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>
                              <div class="form-group">
                                <label class="form-label" for="supplier">Supplier</label>
                                 <div class="form-control-wrap">
                                      <select class="form-control form-select select2" id="supplier"
                                          name="supplier_id" data-placeholder="Select a supplier" >
                                         <option value="" disabled selected>Select a supplier</option>
                                         @foreach($suppliers as $supplier)
                                         <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                          @endforeach
                                      </select>
                                 </div>
                              </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" min="1" name="stock" value="{{ old('stock') }}"
                                        class="form-control">
                                    @error('stock')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Buying Price</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="1" name="buying_price" class="form-control"
                                            value="{{ old('buying_price') }}">
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
                                            value="{{ old('selling_price') }}">
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
                                <div class="icheck-secondary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" name="colors[]" value="black">
                                    <label for="checkboxPrimary1"> Black </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary2" name="colors[]" value="blue">
                                    <label for="checkboxPrimary2"> Blue </label>
                                </div>
                                <div class="icheck-red d-inline">
                                    <input type="checkbox" id="checkboxPrimary3" name="colors[]" value="red">
                                    <label for="checkboxPrimary3"> Red </label>
                                </div>
                                <div class="icheck-warning d-inline">
                                    <input type="checkbox" id="checkboxPrimary4" name="colors[]" value="yellow">
                                    <label for="checkboxPrimary4"> Yellow </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="checkboxPrimary5" name="colors[]" value="green">
                                    <label for="checkboxPrimary5"> Green </label>
                                </div>
                                <div class="icheck-indigo d-inline">
                                    <input type="checkbox" id="checkboxPrimary6" name="colors[]" value="purple">
                                    <label for="checkboxPrimary6"> Purple </label>
                                </div>
                                <div class="icheck-orange d-inline">
                                    <input type="checkbox" id="checkboxPrimary7" name="colors[]" value="orange">
                                    <label for="checkboxPrimary7"> Orange </label>
                                </div>
                                <div class="icheck-pink d-inline">
                                    <input type="checkbox" id="checkboxPrimary8" name="colors[]" value="pink">
                                    <label for="checkboxPrimary8"> Pink </label>
                                </div>
                            </div>




                                <div class="form-group">
                                    <label class="form-label" for="customFileLabel">Product Images</label>
                                    <div class="form-control-wrap">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="images[]" multiple>
                                            <label class="custom-file-label" for="customFile">Choose files</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch3"
                                            onchange="updateStatus()">
                                        <label class="custom-control-label" for="customSwitch3">Inactive</label>
                                    </div>
                                </div>

                                <script>
                                    function updateStatus() {
                                        var switchCheckbox = document.getElementById('customSwitch3');
                                        var switchLabel = document.querySelector('[for="customSwitch3"]');

                                        if (switchCheckbox.checked) {
                                            switchLabel.textContent = 'Active';
                                        } else {
                                            switchLabel.textContent = 'Inactive';
                                        }
                                    }
                                </script>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success swalDefaultSuccess">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
