@extends('admin.dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Members</h4>
                            <a class="btn btn-outline-primary waves-effect waves-light" href="{{ route('members.create')}}">
                                <i class="fa fa-plus-circle"></i> Add New Member
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Group Name</th>
                                        <th>Residence</th>
                                        <th>Postal Address</th>
                                        <th>Town: </th>
                                        <th>Status: </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach($members as $member)
                                    <tr>
                                        <td>{{ $counter++ }}.</td>
                                        <td>{{ $member->id_number }}</td>
                                        <td><a href="{{ route('members.show', $member->id) }}" style="font-weight: bold; text-decoration:none;">{{ $member->name }}</a></td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td><a href="{{ route('sub_groups.show', $member->sub_group_id) }}" style="font-weight: bold; text-decoration:none;">{{ App\Models\SubGroup::find($member->sub_group_id)->name }}</a></td>
                                        <td>{{ $member->residence }}</td>
                                        <td>{{ $member->postal_address }}</td>
                                        <td>{{ $member->town }}</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="hidden" name="status" value="{{ $member->status ? 1 : 0 }}">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $member->id }}"
                                                        data-member-id="{{ $member->id }}" {{ $member->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                                    <label class="custom-control-label" for="customSwitch{{ $member->id }}">Status</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i> Print</a>
                                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="{{ route('members.show', $member->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> View</a>
                                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?')">
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
        </div>
    </div>
</div>

@endsection
