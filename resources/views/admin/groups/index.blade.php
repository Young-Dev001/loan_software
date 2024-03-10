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
                            <li class="breadcrumb-item"><a href="{{ route('groups.create') }}">Add New </a></li>
                            <li class="breadcrumb-item active">Group</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-8">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card h-100">
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Bank Name</th>
                                        <th>Account No</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach($groups as $group)
                                      <tr>
                                        <td>{{ $counter++ }}.</td>
                                        <td>
                                        <a href="{{ route('groups.show', $group->id) }}" style="font-weight: bold;">{{ $group->name }}</a>
                                        </td>
                                        <td>{{ $group->bank_name }}</td>
                                        <td>{{ $group->account_number }}</td>
                                        <td>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="hidden" name="status" value="{{ $group->status ? 1 : 0 }}">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $group->id }}"
                                                       data-group-id="{{ $group->id }}" {{ $group->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                                <label class="custom-control-label" for="customSwitch{{ $group->id }}">Status</label>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                updateStatus('{{ $group->id }}', {{ $group->status ? 'true' : 'false' }});
                                            });

                                            function updateStatus(groupId, initialStatus) {
                                                var switchCheckbox = document.getElementById('customSwitch' + groupId);
                                                var switchLabel = document.querySelector('[for="customSwitch' + groupId + '"]');
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
                                             <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                             <a href="{{ route('groups.show', $group->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> View</a>

                                             <form action="{{ route('groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?')">
                                                 @csrf
                                                 @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                             </form>
                                         </td>
                                        </tr>
                                      @endforeach

                                    </tbody>
                                  </table>
                                </div> <!-- end card body-->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
