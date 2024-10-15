@extends('admin.layouts.master')
@section('coupon', 'active')
@section('title') {{ $title ?? '' }} @endsection
@section('nav_menu', $title)

@push('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    {{-- create modal --}}
    <div class="modal modal-blur fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addCouponModalLabel">Add Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form -->
                <form id="addCouponForm" action="{{ route('admin.coupon.store') }}" method="POST">
                    @csrf
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Coupon name') }} <span class="text-danger">*</span></label>
                                    <input name="name" required class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Coupon name') }}" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coupon_code" class="form-label">{{ __('Coupon code') }} <span class="text-danger">*</span></label>
                                    <input name="coupon_code" required class="form-control @error('coupon_code') is-invalid @enderror" placeholder="{{ __('Coupon code') }}" />
                                    @error('coupon_code')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validity_from" class="form-label">{{ __('Valid from') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="validity_from" name="validity_from" readonly class="form-control @error('validity_from') is-invalid @enderror" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validity_to" class="form-label">{{ __('Valid to') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="validity_to" name="validity_to" readonly class="form-control @error('validity_to') is-invalid @enderror" />
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coupon_type" class="form-label">{{ __('Coupon type') }} <span class="text-danger">*</span></label>
                                    <select id="coupon_type" name="coupon_type" class="form-select">
                                        <option value="percent">Percentage</option>
                                        <option value="amount">Amount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" />
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usability_options" class="form-label">{{ __('Usability') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select id="usability_options" name="usability" class="form-select w-50">
                                            <option value="1">Default</option>
                                            <option value="9999">Unlimited</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <input type="text" id="usability" name="usability" class="form-control" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="addCouponForm" class="btn btn-success ms-auto">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Manage Information</h4>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addCouponModal"
                                    class="btn btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                        <thead>
                                            <tr>
                                                <th width="5%">SN</th>
                                                <th width="10%">Title</th>
                                                <th width="10%">Code</th>
                                                <th width="10%">Valid from</th>
                                                <th width="10%">Valid to</th>
                                                <th width="10%">Coupon type</th>
                                                <th width="10%">Amount</th>
                                                <th width="10%">Usability</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($coupons as $key => $coupon)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $coupon->name }}</td>
                                                    <td>{{ $coupon->coupon_code }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($coupon->validity_from)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($coupon->validity_to)) }}</td>
                                                    <td>{{ $coupon->coupon_type }}</td>
                                                    <td>{{ $coupon->amount }}</td>
                                                    <td>{{ $coupon->usability }}</td>
                                                    <td>                                              
                                                        @if ($coupon->status == 1)
                                                            <span class="badge bg-success text-white">Active</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-secondary btn-sm"
                                                            data-id="{{ $coupon->id }}">Edit</a>
                                                        <a href="{{ route('admin.coupon.view', $coupon->id) }}" class="btn btn-info btn-sm"
                                                            data-id="{{ $coupon->id }}">View</a>
                                                        <a href="{{ route('admin.coupon.delete', $coupon->id) }}"
                                                            id="deleteData" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {

        $("#validity_from").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            onSelect: function(date) {
                var date2 = $('#validity_from').datepicker('getDate');
                console.log(date2);
                date2.setDate(date2.getDate());
                $('#validity_to').datepicker('setDate', date2);
                $('#validity_to').datepicker('option', 'minDate', date2);
            }
        });

        $("#validity_to").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
        });
    });

    $(document).ready(function () {
        $('#usability').val(1).prop('disabled', true);
        $('#usability_options').change(function () {
            if ($(this).val() === 'other') {
                $('#usability').prop('disabled', false);
                $('#usability').val('');
            } else if ($(this).val() === '9999') {
                $('#usability').val(9999);
                $('#usability').prop('disabled', true);
            } else {
                $('#usability').val(1);
                $('#usability').prop('disabled', true);
            }
        });
    });

    $(document).ready(function() {
        var isUserSpecifyDropdown = $('#is_user_specify');
        var userSpecifyDropdown = $('#userSpecifyDropdown');
        var userDropdown = $('#user_id');

        isUserSpecifyDropdown.on('change', function() {
            if (isUserSpecifyDropdown.val() === '1') {
                userSpecifyDropdown.show();
            } else {
                userSpecifyDropdown.hide();
                userDropdown.val([]);
            }
        });
    });

    $(document).ready(function() {
        $('.select2').select2({

            multiple:true
        });
    });
</script>
@endpush

