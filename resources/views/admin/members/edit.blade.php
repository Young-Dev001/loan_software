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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                            <li class="breadcrumb-item active">{{ $member->name }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-8">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ route('members.update', ['member' => $member->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                               <div class="card-body">
                                <h4 class="card-title mb-4">{{ Str::upper($member->name) }} DETAILS</h4>

                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav-justified">
                                <li class="nav-item">
                                    <a href="#personal-details" class="nav-link" data-toggle="tab">
                                        <span class="step-number">01</span>
                                        <span class="step-title">Personal Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-registration-information" class="nav-link" data-toggle="tab">
                                        <span class="step-number">02</span>
                                        <span class="step-title">Registration information</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#progress-system-credentials" class="nav-link" data-toggle="tab">
                                        <span class="step-number">03</span>
                                        <span class="step-title">System Credentials</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number">04</span>
                                        <span class="step-title">Confirm Detail</span>
                                    </a>
                                </li>
                            </ul>

                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="personal-details">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Member Full Names</label>
                                                    <input type="name" class="form-control" id="name" name="name" value="{{ $member->name }}">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">ID/Passport Number</label>
                                                    <input type="number" class="form-control" id="id_number" name="id_number" value="{{ $member->id_number }}">
                                                   @error('id_number')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Phone No.</label>
                                                    <input type="phone" class="form-control" id="phone" name="phone" value="{{ $member->phone }}">
                                                   @error('phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Member Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="photo" class="form-control" id="customFile">
                                                        @error('photo')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                            <div class="col-sm-9 text-secondary">
                                                <img class="rounded-circle" id="showImage"
                                                    src="{{ (!empty($member->photo)) ? url('upload/member_images/'.$member->photo) : url('upload/no_image.jpg') }}"
                                                    width="150px" alt="User profile picture">
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="tab-pane" id="progress-registration-information">
                                  <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="group">Group Name</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-control form-select select2" id="sub_group_id"
                                                            name="sub_group_id" data-placeholder="Select a group" >
                                                            <option value="" disabled selected>Select a group</option>
                                                            @foreach($subgroups as $subgroup)
                                                            <option value="{{ $subgroup->id }}" {{ $subgroup->id == $member->sub_group_id ? 'selected' : '' }} >
                                                                {{ $subgroup->name }}
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('sub_group_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Residence</label>
                                                    <input type="text" class="form-control" id="residence" name="residence" value="{{ $member->residence }}" >
                                                    @error('residence')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Registration Fee</label>
                                                    <input type="number" min="1" class="form-control" id="registration_fee" value="{{ $member->registration_fee }}"  name="registration_fee">
                                                    @error('registration_fee')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Registration Date</label>
                                                    <input type="date" class="form-control" id="registration_date" value="{{ $member->registration_date }}" name="registration_date">
                                                    @error('registration_date')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                        <label for="">Postal Address</label>
                                                        <input type="text" class="form-control" id="postal_address" name="postal_address" value="{{ $member->postal_address }}">
                                                        @error('postal_address')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Town</label>
                                                    <input type="text" class="form-control" id="town" name="town" value="{{ $member->town }}">
                                                    @error('town')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                  </div>
                                            </div>
                                        </div>
                                  </div>
                                </div>
                                <div class="tab-pane" id="progress-system-credentials">
                                    <div>
                                          <div class="row">
                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Email Address</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                              </div>

                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                              </div>
                                          </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-confirm-detail">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <div class="mb-4">
                                                    <button style="border-style: none; background-color: #fff;" class="mdi mdi-check-circle-outline text-success display-4" type="submit"></button>
                                                </div>
                                                <div>
                                                    <h5>Update Details</h5>
                                                    <p class="text-muted">If several languages coalesce, click the check-mark to update!</p>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                            </ul>
                        </div>
                           </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#customFile').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]); // Displaying the selected image
        });
    });
</script>
@endsection
