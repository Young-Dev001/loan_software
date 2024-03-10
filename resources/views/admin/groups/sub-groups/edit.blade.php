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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Group</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-8">
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ route('sub_groups.update', $sub_group->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                 <div class="form-group">
                                        <label class="form-label" for="group">Group Name</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control form-select select2" id="group_id"
                                                name="group_id" data-placeholder="Select a group" >
                                                <option value="" disabled selected>Select a group</option>
                                                @foreach($groups as $group)
                                                <option value="{{ $group->id }}" {{ $group->id == $sub_group->group_id ? 'selected' : '' }} >
                                                    {{ $group->name }}
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('group_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>Sub-Group Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $sub_group->name }}"
                                        placeholder="e.g Groups A, Group B....">
                                    @error('name')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Enter ...">{{ $sub_group->description }}</textarea>
                                    @error('description')
                                    <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="hidden" name="status" value="{{ $group->status ? 1 : 0 }}">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch3"
                                            {{ $group->status ? 'checked' : '' }} onchange="updateStatus()">
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
                                <button type="submit" class="btn btn-success swalDefaultSuccess">Submit</button>
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
