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
    <!-- Main content -->
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
    </style>
    <div class="row mb-8">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card h-100">
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
                                        <span>Invoice Id: #6</span> <br>
                                        <span>Date: 24 / 09 / 2022</span> <br>
                                        <span>Zip code : 560077</span> <br>
                                        <span>Address: #555, Old Malindi Road, Mombasa - Kenya</span> <br>
                                    </th>
                                </tr>
                                <tr class="bg-blue">
                                    <th width="50%" colspan="2">Order Details</th>
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
                                        {{ $member->registration_date }} <br>
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
                                    <td width="10%">Ksh. {{ number_format($product->selling_price, 2) }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
