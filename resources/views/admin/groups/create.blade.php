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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('groups.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Sub-Group Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        placeholder="e.g Groups A, Group B....">
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
                                    <label>Associated Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}"
                                        placeholder="e.g KCB Bank, Equity Bank, Co-Operative Bank.... ">
                                    @error('name')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Account No</label>
                                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}">
                                    @error('name')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
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
