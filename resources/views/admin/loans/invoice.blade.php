<style>
    /* Define styles for printing */
    @media print {
        .no-print {
            display: none !important; /* Hide elements with the 'no-print' class when printing */
        }
    }
</style>

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
        <style>

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 0px !important;
            }
            table thead th {
                height: 28px;
                text-align: left;
                font-size: 16px;
                font-family: sans-serif;
            }
            table, th, td {
                border: 1px solid #ddd;
                padding: 8px;
                font-size: 14px;
            }

            .heading {
                font-size: 24px;
                margin-top: 12px;
                margin-bottom: 12px;
                font-family: sans-serif;
            }
            .small-heading {
                font-size: 18px;
                font-family: sans-serif;
            }
            .total-heading {
                font-size: 18px;
                font-weight: 700;
                font-family: sans-serif;
            }
            .order-details tbody tr td:nth-child(1) {
                width: 20%;
            }
            .order-details tbody tr td:nth-child(3) {
                width: 20%;
            }

            .text-start {
                text-align: left;
            }
            .text-end {
                text-align: right;
            }
            .text-center {
                text-align: center;
            }
            .company-data span {
                margin-bottom: 4px;
                display: inline-block;
                font-family: sans-serif;
                font-size: 14px;
                font-weight: 400;
            }
            .no-border {
                border: 1px solid #fff !important;
            }
            .bg-blue {
                background-color: #1580e4;
                color: #fff;
            }
            .no-border.text-start.heading {
                font-size: 16px;
                text-decoration: underline; /* Adjust the font size as per your requirement */
            }

        </style>
        <div class="row mb-8">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-body">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th width="50%" colspan="2">
                                        <img src="{{ asset('Backend_Theme/assets/images/logo-lg.png') }}" alt="logo-sm-light" height="90" style="display: inline-block; vertical-align: middle;">
                                        <div style="display: inline-block; vertical-align: middle; margin-left: 10px;">
                                            <h2 class="text-start" style="margin-bottom: 0;">Blue Capital</h2>
                                            <p style="margin-top: 0;">Asset Financing App</p>
                                        </div>


                                    </th>
                                    <th width="50%" colspan="2" class="text-end company-data">
                                        <span>Invoice Id: #00{{ $member->id }} </span> <br>
                                        @php
                                            $todayDate = date('d / m / Y');
                                        @endphp

                                        <span>Date: {{ $todayDate }}</span> <br>
                                        <span>Zip code : 560077</span> <br>
                                        <span>Address: #555, Old Malindi Road, Mombasa - Kenya</span> <br>
                                    </th>
                                </tr>
                                <tr class="bg-blue">
                                    <th width="50%" colspan="2">Loan Details</th>
                                    <th width="50%" colspan="2">User Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Name: <br>
                                        Identification No: <br>
                                        Address: <br>
                                        Registration Date: <br>

                                    </td>
                                    <td>{{ $member->name }} <br>
                                        {{ $member->id_number }} <br>
                                        {{ $member->postal_address }} <br>
                                        @php
                                            $date = new DateTime($member->registration_date);
                                            $formattedDate = $date->format('d, M Y');
                                        @endphp



                                        {{ $formattedDate }} <br>
                                    </td>

                                    <td>Phone:<br>
                                        E-mail:
                                    </td>
                                    <td>{{ $member->phone }} <br>
                                        {{ $member->email }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>


                        <table>
                            <thead>
                                <tr>
                                    <th class="no-border text-start heading" colspan="5">
                                         Loan Asset
                                    </th>
                                </tr>
                                <tr class="bg-blue">
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Interest</th>
                                    <th>Loan Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>1. </td>
                                    <td>
                                        {{ $product->name }}
                                    </td>
                                    <td width="20%">Ksh. {{ number_format($product->selling_price, 2) }}</td>
                                    <td width="10%">1</td>

                                @endforeach
                                @foreach($loans as $loan)

                                    <td colspan="1" class="fw-bold">Ksh. {{ number_format($loan->loan_interest, 2) }}</td>
                                    <td colspan="1" class="fw-bold">Ksh. {{ number_format($loan->loan_total, 2) }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <br>

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                              <div class="table-responsive">
                                <table class="table">
                                  <tr>
                                    <th style="width:50%">Interest Rate:</th>
                                    <td>{{ $loan->interest_rate }} %</td>
                                  </tr>
                                  <tr>
                                    <th>Loan Terms:</th>
                                    <td>{{ $loan->term }} months</td>
                                  </tr>
                                  <tr>
                                    <th>Interest Amount:</th>
                                    <td>Ksh. {{ number_format($loan->loan_interest, 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Payments: ({{ $loan->payment_option }}) </th>
                                    <td>Ksh. {{ number_format($loan->payment_amount, 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Total:</th>
                                    <td class="total-heading">Ksh. {{ number_format($loan->loan_total, 2) }}</td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th class="no-border text-start heading" colspan="5">
                                         Payments Analysis
                                    </th>
                                </tr>
                                <tr class="bg-blue">
                                    <th></th>
                                    <th>Payment Date</th>
                                    <th>Amount Paid</th>
                                    <th>Payment method</th>
                                    <th>Transaction Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach($loanPayments->reverse() as $loanPayment)
                                <tr>
                                    <td>{{ $counter++ }}.</td>
                                    <td>{{ $loanPayment->payment_date }}</td>
                                    <td width="30%">Ksh. {{ number_format($loanPayment->amount_paid, 2) }}</td>
                                    <td width="15%">{{ $loanPayment->payment_method }}</td>
                                    <td width="20%">{{ $loanPayment->transaction_id ? $loanPayment->transaction_id : 'Not Available' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-5">
                              <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Total Amount Paid:</th>
                                        <td class="fw-bold" style="color: green;">Ksh. {{ number_format($totalPaidAmount, 2) }}</td>
                                      </tr>
                                  <tr>
                                    <th>Balance:</th>
                                    <td class="fw-bold" style="color: red;">Ksh. {{ number_format($remainingAmount, 2) }}</td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <br>
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="#" onclick="window.print();" class="btn btn-primary"><i class="fas fa-print"></i> Print Invoice</a>
                           </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection
