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
                            <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">List </a></li>
                            <li class="breadcrumb-item active">Groups</li>
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
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subGroups as $subGroup)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td><a href="{{ route('sub_groups.show', $subGroup->id) }}" style="font-weight: bold;">{{ $subGroup->name }}</a></td>
                                                <td>
                                                    <div class="form-subGroup">
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input type="hidden" name="status" value="{{ $subGroup->status ? 1 : 0 }}">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{ $subGroup->id }}" data-subGroup-id="{{ $subGroup->id }}" {{ $subGroup->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                                            <label class="custom-control-label" for="customSwitch{{ $subGroup->id }}">{{ $subGroup->status ? 'Active' : 'Inactive' }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                    <a href="{{ route('sub_groups.edit', $subGroup->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="{{ route('sub_groups.show', $subGroup->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> View</a>
                                                    <form action="{{ route('sub_groups.destroy', $subGroup->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subGroup?')">
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
                                </div> <!-- end card body-->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
