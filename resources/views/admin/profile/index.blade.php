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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-5">
            <div class="col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ (!empty($adminData->photo))?  url('upload/admin_images/'.$adminData->photo):
                                                                url('upload/no_image.jpg') }}" width="170px"
                                 alt="User profile picture">
                          </div>
                          <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                          <p class="text-muted text-center">{{ Auth::user()->email }}</p>

                          <form  method="post" action="{{ route('admin.profile.store') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="name" class="form-control" value="{{ $adminData->name }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="email" class="form-control" value="{{ $adminData->email }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="phone" class="form-control" value="{{ $adminData->phone }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="address" class="form-control" value="{{ $adminData->address }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Profile Image</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <input id="photo" class="form-control" type="file" name="photo">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0"></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <img id="showImage" src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo)
                                    : url('upload/no_image.jpg') }}" alt="Admin" class="rounded-circle" width="70">
                            </div>
                        </div>
                            <hr>
                            <input type="submit" class="btn btn-primary" value="Save Changes">

                        </form>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-xl-6">
                <div class="card mb-0">
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="{{ route('admin.update.password') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Old Password</label>
                                <br>
                                <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" id="oldpassword"
                                    placeholder="Enter Old Password" >
                                @error('oldpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">New Password</label>
                                <br>
                                <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror" id="newpassword"
                                    placeholder="Enter New Password" >
                                @error('newpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Confirm Password</label>
                                <br>
                                <input type="password" name="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" id="confirm-password"
                                    placeholder="Confirm Password" >
                                @error('confirm-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <hr>

                            <div class="col-sm-9 text-secondary">
                                <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                            </div>

                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row-->
        <div style='clear:both'></div>

    </div> <!-- container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
          $(document).ready(function(){
             $('#photo').change(function(e){
                  var reader = new FileReader();
                   reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]); // Displaying the selected image
    });
});
</script>
 @endsection
