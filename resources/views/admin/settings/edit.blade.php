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

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('settings.update', ['setting' => $setting->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="key">Setting Name</label>
                                <input type="text" name="key" id="key" class="form-control" value="{{ $setting->key }}" required>
                            </div>

                            <div class="form-group">
                                <label for="value">Setting Value</label>
                                <input type="text" name="value" id="value" class="form-control" value="{{ $setting->value }}" required>
                            </div>
                            <br>

                            <button type="submit" class="btn btn-primary">Update Setting</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
