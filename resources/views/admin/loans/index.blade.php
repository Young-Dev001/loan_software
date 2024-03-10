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
                            <li class="breadcrumb-item"><a href="{{ route('loans.create') }}">Add New </a></li>
                            <li class="breadcrumb-item active">Loan</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-12">
            <div class="col-xl-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card h-100">
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Member</th>
                                            <th>Asset</th>
                                            <th>Loan Amount</th>
                                            <th>Interest rate (%)</th>
                                            <th>Payment Duration</th>
                                            <th>Payment Analysis</th>
                                            <th>Start Date</th>
                                            <th>Approval Status</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loans as $index => $loan)
                                        <tr>
                                            <td>{{ $index + 1 }}.</td>
                                            <td>
                                                <a href="{{ route('members.show', $loan->member_id) }}" data-toggle="modal" data-target="#modal-default" style="font-weight: bold; text-decoration:none;">{{ App\Models\Member::find($loan->member_id)->name }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('products.show', $loan->product_id) }}" style="font-weight: bold; text-decoration:none;">{{ App\Models\Product::find($loan->product_id)->name }}</a>
                                            </td>
                                            <td>Ksh.{{ number_format ( $loan->loan_total ,2 ) }}</td>
                                            <td>{{ $loan->interest_rate }}%</td>
                                            <td>{{ $loan->term }} Months</td>
                                            <td>
                                                {{ $loan->payment_option }} <br>
                                                Ksh.{{ number_format($loan->payment_amount, 2) }}
                                            </td>
                                            <td>{{ $loan->start_date }}</td>
                                            <td>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="hidden" name="approved" value="{{ $loan->approved ? 1 : 0 }}">
                                                    <input type="checkbox" class="custom-control-input approval-switch" id="approvalSwitch{{ $loan->id }}"
                                                        data-loan-id="{{ $loan->id }}" {{ $loan->approved ? 'checked' : '' }} disabled>
                                                    <label class="custom-control-label" for="approvalSwitch{{ $loan->id }}">{{ $loan->approved ? 'Approved' : 'Approval pending' }}</label>
                                                </div>
                                            </div>
                                        </td>

                                          <td>
                                              <div class="form-group">
                                                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                      <input type="hidden" name="completed" value="{{ $loan->completed ? 1 : 0 }}">
                                                      <input type="checkbox" class="custom-control-input" id="statusSwitch{{ $loan->id }}"
                                                          data-loan-id="{{ $loan->id }}" {{ $loan->completed ? 'checked' : '' }} disabled>
                                                      <label class="custom-control-label" for="statusSwitch{{ $loan->id }}">{{ $loan->completed ? 'Completed' : 'Incomplete' }}</label>
                                                  </div>
                                              </div>
                                          </td>

                                          <td>
                                                @php
                                                    $member = $loan->member;
                                                @endphp
                                                <div class="btn-group">
                                                    <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-primary  btn-sm" title="Edit Loan">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-success  btn-sm" title="Pay Loan">
                                                        <i class="fab fa-paypal"></i> Pay Now!
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Delete Loan " onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this loan?')) { document.getElementById('delete-loan-{{ $loan->id }}').submit(); }">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                    <form id="delete-loan-{{ $loan->id }}" action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
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
    </div>

@endsection
