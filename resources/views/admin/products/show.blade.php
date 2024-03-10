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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $product->name }}</a></li>
                            <li class="breadcrumb-item active">Images</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-5">
            <div class="col-lg-4">
                <div class="card h-50">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0;">Product Information</h3>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                          </div>
                          <hr>
                        <div class="">
                            @if ($product->images->isNotEmpty())
                            <div id="carouselExampleCaption" class="carousel slide pointer-event" data-bs-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    @foreach($product->images as $key => $image)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image->image_path) }}" alt="..." class="d-block img-fluid">
                                    </div>
                                    @endforeach
                                <a class="carousel-control-prev" href="#carouselExampleCaption" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaption" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" class="product-image" alt="No Image">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-0">
                    <div class="card-body">
                        <h3 class="my-3">{{ $product->name }}</h3>
                        <h3 class="my-3">{!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!}</h3>

                        <hr>
                        <h4>Available Colors</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @foreach(json_decode($product->colors) as $color)
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" autocomplete="off">
                                    {{ ucfirst($color) }}
                                    <br>
                                    <i class="fas fa-circle fa-2x text-{{ $color }}"></i>
                                </label>
                            @endforeach
                        </div>
                        <div class="bg-white py-2 px-3 mt-4" style="border-radius: 20px;">
                            <label for="Price">Price:</label>
                            <input class="form-control is-valid"
                                   type="text"
                                   name=""
                                   style="font-weight:bold;
                        color:green;
                        border-radius: 20px;
                        font-size: 24px;
                        padding: 25px;"
                                   id=""
                                   value="Ksh. {{ number_format($product->selling_price, 2) }}"
                                   disabled>
                        </div>

                        <div class="mt-4">
                            <div class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Add to Cart
                            </div>

                            <div class="btn btn-success btn-lg btn-flat">
                                <i class="fas fa-heart fa-lg mr-2"></i>
                                Add to Wishlist
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{ $product->description }}</div>
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
