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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $loan->name }}</a></li>
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
                            <h3 style="margin: 0;">Loan Information</h3>
                            <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                          </div>
                          <hr>
                        <form action="{{ route('loan_payments.store') }}" method="post" enctype="multipart/form-data" id="registrationForm">
                            @csrf
                            <div class="bs-stepper-content">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('notification'))
                                    <div class="alert alert-{{ session('notification.alert-type') }}">
                                        <input  type="text" class="form-control is-invalid" value="{{ session('notification.message') }}" style="color:red;">
                                    </div>
                                @endif
                                <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="member_name">Member</label>
                                    <input type="text" class="form-control is-valid" value="{{ App\Models\Member::find($loan->member_id)->name }}" id="member_name" readonly>
                                    <input type="hidden" name="member_id" value="{{ $loan->member_id }}">
                                </div>

                                    <div class="form-group">
                                        <label for="amount">Loan Amount:</label>
                                        <input type="text" name="amount" id="amount" class="form-control is-valid" value="Ksh.{{ number_format($loan->loan_total, 2) }}" readonly>
                                    </div>
                                    <input hidden type="text" name="loan_id" id="loan_id" class="form-control is-valid" value="{{ $loan->id }}" readonly>
                                    <div class="form-group">
                                        <label for="asset_taken">Asset Taken</label>
                                        <input type="text" name="asset_taken" id="asset_taken" value="{{ App\Models\Product::find($loan->product_id)->name }}"  class="form-control is-valid" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount_paid">Amount Paid</label>
                                        <input type="text" name="amount_paid" id="amount_paid" class="form-control" placeholder="Enter the Amount Paid">
                                        <span id="error_amount_paid" style="color: red;"></span>
                                    </div>

                                    <div class="payment-options">
                                        <label>Payment Method</label>
                                        <div class="icheck-success d-inline">
                                            <input type="radio" checked name="payment_method" id="cash" value="cash">
                                            <label for="cash">Cash</label>
                                        </div>
                                        <div class="icheck-success d-inline">
                                            <input type="radio" name="payment_method" id="mpesa" value="mpesa">
                                            <label for="mpesa">Mpesa</label>
                                        </div>
                                        <div class="icheck-success d-inline">
                                            <input type="radio" name="payment_method" id="cheque" value="cheque">
                                            <label for="cheque">Cheque</label>
                                        </div>
                                        <div class="icheck-success d-inline">
                                            <input type="radio" name="payment_method" id="others" value="others">
                                            <label for="others">Others</label>
                                        </div>
                                    </div>
                                    <style>
                                        /* CSS for vertical payment options */
                                        .payment-options {
                                            display: flex;
                                            flex-direction: column;
                                        }
                                        .icheck-success {
                                            margin-bottom: 10px; /* Adjust as needed */
                                        }
                                    </style>
                                    <hr>
                                    <div class="form-group" id="transaction_id_field" style="display: none;">
                                        <label for="transaction_id">Transaction ID</label>
                                        <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="Enter the Transaction ID">
                                    </div>
                                    <div class="form-group" id="cheque_no_field" style="display: none;">
                                        <label for="cheque_no">Cheque No</label>
                                        <input type="text" name="cheque_no" id="cheque_no" class="form-control" placeholder="Enter the Cheque No">
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_date">Loan Payment Date:</label>
                                        <input type="date" name="payment_date" id="payment_date" class="form-control">
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success"><i class="far fa-credit-card"></i> Submit Payments</button>
                                <br><br>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end row-->

            <div class="col-lg-8">
                <div class="card mb-0">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 class="mb-sm-0" style="text-decoration: underline;">PAYMENT ANALYSIS</h4>
                          </div>
                          <hr>
                        <div class="table-responsive">
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Payment Date</th>
                                        <th>Amount Paid</th>
                                        <th>Payment Method</th>
                                        <th>Transaction Id/Cheque No</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loanPayments as $loanPayment)
                                    <tr>
                                        <td>
                                        <input type="checkbox" id="checkboxPrimary2" name="colors[]" value="blue">
                                        </td>
                                        <td>
                                            <a href="#" style="font-weight: bold; color:red">{{ $loanPayment->payment_date }}</a>
                                        </td>
                                        <td>Ksh.{{ number_format ( $loanPayment->amount_paid ,2 ) }}</td>

                                        <td>
                                            {{ $loanPayment->payment_method }} = Ksh.{{ number_format ( $loanPayment->amount_paid ,2 ) }}
                                        <td>
                                            {{ $loanPayment->transaction_id ? $loanPayment->transaction_id : ($loanPayment->cheque_no ? $loanPayment->cheque_no : 'Not Available') }}
                                        </td>

                                        <td>
                                            <div class="btn-group">


                                                <form action="{{ route('loan_payments.destroy', $loanPayment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Loan Payment?')">
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
                            @php
                            $inputClass = ($remainingAmount == 0 || $remainingAmount < 0) ? 'is-valid' : 'is-invalid';
                            $inputColor = ($remainingAmount == 0 || $remainingAmount < 0) ? 'green' : 'red';
                            $balanceMessage = '';

                            if ($remainingAmount == 0) {
                                $balanceMessage = 'NIL Balance';
                            } elseif ($remainingAmount > 0) {
                                $balanceMessage = "Balance = Ksh." . number_format($remainingAmount, 2);
                            } else {
                                $balanceMessage = "Savings = Ksh." . number_format(abs($remainingAmount), 2);
                            }
                        @endphp

                        <div class="bg-white py-2 px-3 mt-4" style="border-radius: 20px;">
                            <input class="form-control {{ $inputClass }}"
                                type="text"
                                name=""
                                style="font-weight:bold;
                                        color:{{ $inputColor }};
                                        border-radius: 20px;
                                        font-size: 18px;
                                        padding: 14px;"
                                id=""
                                value="{{ $balanceMessage }}"
                                disabled>
                                <div class="mt-3" style="font-weight: bold; color:green;">
                                Total Paid Amount: {{ $totalPaidAmount }}
                                </div>
                        </div>
                       </div>
                       <br><br>
                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                @foreach($members as $member)
                                <a href="{{ route('loans.print_invoice', ['member' => $member]) }}" rel="noopener" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Print Payments</a>
                                @endforeach
                            </div>
                        </div>
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
    document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var paymentMethod = this.value;
            if (paymentMethod === 'mpesa') {
                document.getElementById('transaction_id_field').style.display = 'block';
                document.getElementById('cheque_no_field').style.display = 'none';
            } else if (paymentMethod === 'cheque') {
                document.getElementById('transaction_id_field').style.display = 'none';
                document.getElementById('cheque_no_field').style.display = 'block';
            } else {
                document.getElementById('transaction_id_field').style.display = 'none';
                document.getElementById('cheque_no_field').style.display = 'none';
            }
        });
    });
</script>

 @endsection
