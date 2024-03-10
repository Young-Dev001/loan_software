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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $supplier->name }}</a></li>
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
                        <div class="form-group">
                            <h3 class="my-3">
                                {!! DNS2D::getBarcodeHTML($supplier->phone, 'QRCODE', 4, 4, 'green', true) !!}
                            </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Full Names</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $supplier->name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Phone No</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $supplier->phone }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Email</label>
                             <input type="email" class="form-control is-valid" id="inputSuccess" value="{{ $supplier->email }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Physical Address</label>
                            <textarea name="address" class="form-control is-valid" id="inputSuccess" cols="30" rows="2">{{ $supplier->address }}</textarea>
                          </div>

                    </div>
                </div>
            </div> <!-- end row-->
            <div style='clear:both'></div>

    </div> <!-- container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle image selection
        $('.product-image-thumb').on('click', function () {
            var $image_element = $(this).find('img');
            var newSrc = $image_element.attr('src');
            $('.product-image').attr('src', newSrc);
            $('.product-image-thumb.active').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
 @endsection
