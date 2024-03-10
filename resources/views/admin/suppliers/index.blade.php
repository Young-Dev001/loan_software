@extends('admin.dashboard')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Suppliers</h4>
                            <a class="btn btn-outline-primary waves-effect waves-light" href="{{ route('suppliers.create')}}">
                                <i class="fa fa-plus-circle"></i> Add New supplier
                            </a>
                        </div>

                        <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Name</th>
                                  <th>Email</th>
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

                              @foreach($suppliers as $supplier)
                                <tr>
                                <td>{{ $counter++ }}.</td>
                                    <td>
                                      <a href="{{ route('suppliers.show', $supplier->id) }}" style="font-weight: bold; text-decoration:none;">{{ $supplier->name }}</a>
                                  </td>
                                    <td style="font-weight:bolder;">
                                        <i style="color: green;" class="ri-mail-check-fill"></i> {{ $supplier->email }}
                                    </td>

                                  <td style="font-weight: bolder;">{{ $supplier->phone }}</td>
                                  <td>{{ $supplier->address }}</td>
                                  <td>
                                  <div class="form-group">
                                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                          <input type="hidden" name="status" value="{{ $supplier->status ? 1 : 0 }}">
                                          <input type="checkbox" class="custom-control-input" id="customSwitch{{ $supplier->id }}"
                                                 data-supplier-id="{{ $supplier->id }}" {{ $supplier->status ? 'checked' : '' }} onchange="updateStatus(this)">
                                          <label class="custom-control-label" for="customSwitch{{ $supplier->id }}">Status</label>
                                      </div>
                                  </div>

                                  <script>
                                      document.addEventListener("DOMContentLoaded", function () {
                                          updateStatus('{{ $supplier->id }}', {{ $supplier->status ? 'true' : 'false' }});
                                      });

                                      function updateStatus(supplierId, initialStatus) {
                                          var switchCheckbox = document.getElementById('customSwitch' + supplierId);
                                          var switchLabel = document.querySelector('[for="customSwitch' + supplierId + '"]');
                                          var statusInput = document.getElementsByName('status')[0];

                                          if (initialStatus) {
                                              switchLabel.textContent = 'Active';
                                              statusInput.value = 1;
                                              // Additional logic or actions based on the 'active' state
                                          } else {
                                              switchLabel.textContent = 'Inactive';
                                              statusInput.value = 0;
                                              // Additional logic or actions based on the 'inactive' state
                                          }

                                          switchCheckbox.addEventListener('change', function () {
                                              if (switchCheckbox.checked) {
                                                 switchLabel.textContent = 'Active';
                                                  statusInput.value = 1;
                                                  // Additional logic or actions when the switch is changed to 'active'
                                              } else {
                                                  switchLabel.textContent = 'Inactive';
                                                  statusInput.value = 0;
                                                  // Additional logic or actions when the switch is changed to 'inactive'
                                              }
                                          });
                                      }
                                  </script>

                                  <td>
                                    <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                       <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>

                                       <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                                           @csrf
                                           @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                       </form>
                                    </div>
                                   </td>
                                  </tr>
                                @endforeach

                              </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div>
    </div>

@endsection
