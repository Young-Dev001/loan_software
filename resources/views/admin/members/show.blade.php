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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $member->name }}</a></li>
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
                                <h3 style="margin: 0;">Personal Information</h3>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                              </div>

                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Full Names</label>
                               <input type="text" class="form-control" name="name"  value="{{ $member->name }}" readonly>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">ID/Passport No</label>
                               <input type="text" class="form-control" name="id_number"  value="{{ $member->id_number }}" readonly>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Phone No</label>
                               <input type="text" class="form-control" name="phone"  value="{{ $member->phone }}" readonly>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Nationality</label>
                               <input type="text" class="form-control" name="nationality"  value="{{ $member->nationality }}" readonly>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Postal Address</label>
                              <textarea name="postal_address" class="form-control" name="postal_address"  cols="30" rows="2" readonly>{{ $member->postal_address }} </textarea>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Residence</label>
                               <input type="text" class="form-control" name="residence"  value="{{ $member->residence }}" readonly>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label" for="inputSuccess">Town</label>
                               <input type="text" class="form-control" name="town"  value="{{ $member->town }}" readonly>
                            </div>
                     </div>
                </div>
            </div> <!-- end row-->
            <div class="col-lg-4">
                <div class="card mb-0">
                    <div class="card-body">
                        <h3>Loan Information</h3>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Group</label>
                            <input type="text" class="form-control is-valid" name="sub_group_id" id="inputSuccess"  value="{{ App\Models\SubGroup::find($member->sub_group_id)->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Registration Date</label>
                            <input type="text" class="form-control is-valid" name="registration_date" id="inputSuccess" value="{{ $member->registration_date }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">registration Fee</label>
                            <input type="text" class="form-control is-valid" name="registration_fee" id="registration_fee" value="{{ $member->registration_fee }}" readonly>
                        </div>
                        <label class="col-form-label" for="inputSuccess">Scan Me!</label>
                        {!! DNS2D::getBarcodeHTML($member->phone, 'QRCODE', 4, 4, 'black', true) !!}

                    </div>
                </div>
            </div> <!-- end row-->
            <div class="col-lg-4">
                <div class="card mb-0">
                    <div class="card-body">
                        <h3>Login Credentials</h3>
                        <form action="{{ route('members.profile.update', ['id' => $member->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                                <div class="text-center">
                                    <img class=" rounded-circle"
                                         src="{{ (!empty($member->photo))?  url('upload/member_images/'.$member->photo):
                                                                        url('upload/no_image.jpg') }}" width="170px"
                                         alt="User profile picture">
                                  </div>
                                <!-- Form Fields -->
                                <div class="form-group">
                                    <label for="photo">Member Image</label>
                                    <div class="input-group">
                                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" id="photo" value="{{ $member->photo }}" readonly>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light ml-4">Update</button>
                                        </div>
                                    </div>
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                           </form>

                                <form action="{{ route('members.password.update', ['id' => $member->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $member->email }}" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Old Password</label>
                                    <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" id="oldpassword" placeholder="Enter Old Password">
                                    @error('oldpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="newpassword">New Password</label>
                                    <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror" id="newpassword" placeholder="Enter New Password">
                                    @error('newpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="newpassword_confirmation" class="form-control @error('newpassword_confirmation') is-invalid @enderror" id="confirm_password" placeholder="Confirm New Password">
                                    @error('newpassword_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br>

                                <!-- Submit Button -->
                                <div class="col-sm-9 text-secondary">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </form>

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
