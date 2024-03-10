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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $group->name }}</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-5">
            <div class="col-lg-4">
                <div class="card mb-0">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 style="margin: 0;">{{ Str::upper($group->name) }} DESCRIPTION</h5>
                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                          </div>
                          <hr>
                        <div class="form-group">
                            <h3 class="my-3">
                                {!! DNS2D::getBarcodeHTML($group->account_number, 'QRCODE', 4, 4, 'green', true) !!}
                            </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Group Name</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $group->name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Bank Name</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $group->bank_name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Account Number</label>
                             <input type="number" class="form-control is-valid" id="inputSuccess" value="{{ $group->account_number }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Description</label>
                            <textarea name="description" class="form-control is-valid" id="inputSuccess" cols="30" rows="2">{{ $group->description }}</textarea>
                          </div>

                    </div>
                </div>
            </div> <!-- end row-->

            <div class="col-lg-8">
                <div class="card mb-0">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 class="mb-sm-0" style="text-decoration: underline;">THE WATANO SUB-GROUPS</h4>
                          </div>
                          <hr>
                        <div class="table-responsive">
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach($sub_groups as $sub_group)
                                  <tr>
                                       <td>{{ $counter++ }}.</td>
                                        <td>
                                        <a href="{{ route('sub_groups.show', $sub_group->id) }}" style="font-weight: bold;">{{ $sub_group->name }}</a>
                                        </td>
                                        <td>{{ $sub_group->description }}</td>

                                        <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="hidden" name="status" value="{{ $sub_group->status ? 1 : 0 }}">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $sub_group->id }}"
                                                    data-sub_group-id="{{ $sub_group->id }}" {{ $sub_group->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                                <label class="custom-control-label" for="customSwitch{{ $sub_group->id }}">Status</label>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                updateStatus('{{ $sub_group->id }}', {{ $sub_group->status ? 'true' : 'false' }});
                                            });

                                            function updateStatus(sub_groupId, initialStatus) {
                                                var switchCheckbox = document.getElementById('customSwitch' + sub_groupId);
                                                var switchLabel = document.querySelector('[for="customSwitch' + sub_groupId + '"]');
                                                var statusInput = document.getElementsByName('status')[0];

                                                if (initialStatus) {
                                                    switchLabel.textContent = 'Active';
                                                    statusInput.value = 1;
                                                    // Additional logic or actions based on the 'active' state
                                                } else {
                                                    switchLabel.textContent = 'Inactive';
                                                    statusInput.value = 0;
                                                    // Additional logic or actions based on the 'inactive' state
                                                }

                                                switchCheckbox.addEventListener('change', function () {
                                                    if (switchCheckbox.checked) {
                                                    switchLabel.textContent = 'Active';
                                                        statusInput.value = 1;
                                                        // Additional logic or actions when the switch is changed to 'active'
                                                    } else {
                                                        switchLabel.textContent = 'Inactive';
                                                        statusInput.value = 0;
                                                        // Additional logic or actions when the switch is changed to 'inactive'
                                                    }
                                                });
                                            }
                                        </script>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                <a href="{{ route('sub_groups.edit', $sub_group->id) }}" class="btn btn-primary btn-sm"><i
                                                class="fas fa-edit"></i>
                                                    Edit
                                                </a>

                                                <form action="{{ route('sub_groups.destroy', $sub_group->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this sub-group?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash"></i> Delete</button>
                                                </form>
                                        </div>
                                    </td>

                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus-circle"></i> Add New Watano-Group</button>

 <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New (Watano Group)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('sub_groups.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="form-group">
                            <label>Sub-Group Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g Groups A, Group B....">
                            @error('name')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter ...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger" style="color: red; font-weight:bold;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3" onchange="updateStatus()">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
                    </div>
                </div>
            </div> <!-- end row-->
            <div style='clear:both'></div>

    </div> <!-- container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle image selection
        $('.product-image-thumb').on('click', function () {
            var $image_element = $(this).find('img');
            var newSrc = $image_element.attr('src');
            $('.product-image').attr('src', newSrc);
            $('.product-image-thumb.active').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
 @endsection
