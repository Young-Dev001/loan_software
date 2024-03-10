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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $subGroup->name }}</a></li>
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
                            <h5 style="margin: 0;">{{ Str::upper($subGroup->name) }} DESCRIPTION</h5>
                            <a href="{{ route('sub_groups.edit', $subGroup->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                          </div>
                          <hr>
                        <div class="form-group">
                            <h3 class="my-3">
                                {!! DNS2D::getBarcodeHTML($subGroup->name, 'QRCODE', 4, 4, 'green', true) !!}
                            </h3>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">SubGroup Name</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $subGroup->name }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Created At</label>
                             <input type="text" class="form-control is-valid" id="inputSuccess" value="{{ $subGroup->created_at }}" readonly>
                          </div>
                          <div class="form-group">
                            <label class="col-form-label" for="inputSuccess">Description</label>
                            <textarea name="description" class="form-control is-valid" id="inputSuccess" cols="30" rows="2">{{ $subGroup->description }}</textarea>
                          </div>

                    </div>
                </div>
            </div> <!-- end row-->

            <div class="col-lg-8">
                <div class="card mb-0">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 class="mb-sm-0" style="text-decoration: underline;">MEMBERS (WATANO)</h4>
                          </div>
                          <hr>
                        <div class="table-responsive">
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $counter = 1;
                                @endphp
                                @foreach($members as $member) <!-- Use $members instead of $group -->
                                <tr>
                                    <td>{{ $counter++ }}.</td>
                                    <td>
                                    <a href="{{ route('members.show', $member->id) }}" style="font-weight: bold;">{{ $member->name }}</a>
                                    </td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->postal_address }}</td>

                                    <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="hidden" name="status" value="{{ $member->status ? 1 : 0 }}">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch{{ $member->id }}"
                                              data-member-id="{{ $member->id }}" {{ $member->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                        <label class="custom-control-label" for="customSwitch{{ $member->id }}">Status</label>
                                    </div>
                                </div>
                              </td>
                              <td>
                                <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                      <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary btn-sm"><i
                                          class="fas fa-edit"></i> Edit</a>
                                  <a href="{{ route('members.show', $member->id) }}" class="btn btn-success btn-sm"><i
                                          class="fas fa-eye"></i> View</a>

                                  <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this member?')">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger btn-sm"><i
                                              class="fas fa-trash"></i> Delete</button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                          </table>
                          <a class="btn btn-primary" href="{{ route('members.create')}}"><i class="fa fa-plus-circle"></i> Add New Member</a>
                      </div>


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
