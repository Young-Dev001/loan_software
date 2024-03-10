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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softwares'</a></li>
                            <li class="breadcrumb-item active">Settings</li>
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
                        <div class="card-body">
                        <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th></th>
                                </tr>
                              </thead>
                              <tbody>
                              @php
                                  $counter = 1;
                              @endphp

                               @foreach($settings as $setting)
                                <tr>
                                <td>{{ $counter++ }}.</td>
                                <td>{{ $setting->key }}</td>
                                <td>{{ $setting->value }}</td>
                                <td>
                                    <!-- Add buttons for edit and delete -->
                                    <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this setting?')"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                                  </tr>
                                @endforeach

                              </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div>
                </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div>
    </div>

@endsection
