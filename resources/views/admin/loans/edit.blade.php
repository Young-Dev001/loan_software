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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Loan</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                        <div class="row">
                            <form action="{{ route('loans.update', $loan->id) }}" method="post" enctype="multipart/form-data" id="registrationForm">
                                @csrf
                                @method('PUT')
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
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <label for="member_id">Member:</label>
                                                <select name="member_id" id="member_id" class="form-control" disabled>
                                                    <option value="" disabled selected>--Select Member--</option>
                                                    @foreach($members as $member)
                                                        @php
                                                            $groupName = $member->group ? $member->group->name : 'No Group';
                                                        @endphp
                                                        <option value="{{ $member->id }}" data-group-id="{{ $member->group_id }}" {{ $loan->member_id == $member->id ? 'selected' : '' }}>
                                                            {{ $member->name }} - {{ $groupName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            {{-- Text input field to display the selected member's group_id --}}
                                                <input type="text" name="sub_group_id" id="sub_group_id" class="form-control"  value="{{ $loan->group_id }}"  hidden>


                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#member_id').change(function() {
                                                        var selectedGroupId = $(this).find(':selected').data('group-id');
                                                        $('#sub_group_id').val(selectedGroupId);
                                                    });
                                                });
                                            </script>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="product_id">Product:</label>
                                                    <select name="product_id" id="product_id" class="form-control">
                                                        <option value="" disabled selected>--Select product--</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ isset($loan) && $loan->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="amount">Amount:</label>
                                                    <input type="text" name="amount" id="amount" class="form-control" value="{{ $loan->amount }}" readonly>
                                                </div>
                                            </div>
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="interest_rate">Interest Rate:</label>
                                                    <input type="text" name="interest_rate" id="interest_rate" value="{{ $loan->interest_rate }}" class="form-control">
                                                </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                    <input type="text" name="quantity" id="quantity" value="1" class="form-control" style="display: none;">

                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="term">Term (months)</label>
                                                    <input type="number" name="term" class="form-control" id="term" value="{{ $loan->term }}">
                                                </div>
                                             </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="term">Loan Interest </label>
                                                    <input type="number" name="loan_interest" class="form-control " id="loan_interest" value="{{ $loan->loan_interest }}" readonly required>
                                                </div>
                                                </div>
                                                <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="loan_total">Loan Total:</label>
                                                    <input type="number" name="loan_total" id="loan_total" class="form-control" value="{{ $loan->loan_total }}" readonly required>
                                                </div>
                                                </div>
                                             </div>
                                                <hr>
                                                <label for="term" style="text-decoration: underline;">Payment Terms</label>
                                                <div class="payment-options">
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="payment_option" id="daily" value="daily">
                                                        <label for="daily">Daily</label>
                                                    </div>

                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="payment_option" id="weekly" value="weekly">
                                                        <label for="weekly">Weekly</label>
                                                    </div>

                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="payment_option" id="monthly" value="monthly">
                                                        <label for="monthly">Monthly</label>
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="payment_amount">Payment Amount:</label>
                                                            <input type="number" name="payment_amount" id="payment_amount" class="form-control" value="{{ $loan->payment_amount }}" readonly required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="start_date">Loan Start Date:</label>
                                                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ isset($loan) ? $loan->start_date : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description:</label>
                                                    <textarea name="description" id="description" class="form-control">{{ isset($loan) ? $loan->description : '' }}</textarea>
                                                </div>
                                                <br>
                                                <button class="btn btn-success" type="submit"> Update Loan</button>
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Event listener for changes in the payment options
        $('input[name="payment_option"]').change(function() {
            var paymentOption = $(this).val();
            var loanTotal = parseFloat($('#loan_total').val());
            var term = parseFloat($('#term').val());

            if (paymentOption === 'daily') {
                var paymentAmount = loanTotal / (term * 4 * 7);
            } else if (paymentOption === 'weekly') {
                var paymentAmount = loanTotal / (term * 4);
            } else { // Monthly
                var paymentAmount = loanTotal / term;
            }

            $('#payment_amount').val(paymentAmount.toFixed(2));
        });
    });

    // Function to calculate and display loan interest
    function calculateLoanInterest() {
        var amount = parseFloat(document.getElementById('amount').value);
        var interestRate = parseFloat(document.getElementById('interest_rate').value);
        var term = parseFloat(document.getElementById('term').value);
        var loanInterest = (amount * interestRate / 100 * term).toFixed(2); // Calculate loan interest

        // Display the calculated loan interest
        document.getElementById('loan_interest').value = loanInterest;

        // Calculate total amount (loan amount + interest)
        var totalAmount = parseFloat(amount) + parseFloat(loanInterest);
        document.getElementById('loan_total').value = totalAmount.toFixed(2);

        // Trigger the change event to update the payment amount based on the selected payment option
        $('input[name="payment_option"]:checked').trigger('change');
    }

    // Event listener for input fields to trigger calculation
    document.querySelectorAll('input').forEach(function(input) {
        input.addEventListener('input', function() {
            // If text is inputted, calculate the loan interest and total amount
            calculateLoanInterest();
        });
    });

    // When the product selection changes
    $('#product_id').change(function() {
        var productId = $(this).val(); // Get the selected product ID
        var amount = getAmount(productId); // Get the amount for the selected product
        $('#amount').val(amount); // Update the amount field

        // Calculate loan interest when product changes
        calculateLoanInterest();
    });

    // Function to retrieve the amount for a given product ID
    function getAmount(productId) {
        // Loop through the products to find the one with the matching ID
        @foreach($products as $product)
            if ("{{ $product->id }}" == productId) {
                return "{{ $product->selling_price }}"; // Return the selling price of the product as the amount
            }
        @endforeach
        return ''; // Return an empty string if the product ID is not found
    }
</script>
<script>
    // JavaScript code to select the appropriate payment option when editing the loan application
    $(document).ready(function() {
        var paymentOption = "{{ $loan->payment_option }}"; // Get the payment option from the PHP variable

        // Check the radio button corresponding to the payment option
        $('input[name="payment_option"][value="' + paymentOption + '"]').prop('checked', true);
    });
</script>


@endsection
