@extends('admin.layouts.master')
@section('coupon', 'active')
@section('title') {{ $title ?? '' }} @endsection
@section('nav_menu', $title)
@push('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header">
                                <h3 class="card-title">Coupon Edit</h3>
                            </div>
                            <form id="editCouponForm" action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name">{{ __('Coupon Name') }} <span class="text-danger">*</span></label>
                                                <input name="name" required class="form-control @error('name') border-danger @enderror"
                                                    value="{{ $coupon->name }}" placeholder="{{ __('Coupon Name') }}" />
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="coupon_code">{{ __('Coupon Code') }} <span class="text-danger">*</span></label>
                                                <input name="coupon_code" required class="form-control @error('coupon_code') border-danger @enderror"
                                                    value="{{ $coupon->coupon_code }}" placeholder="{{ __('Coupon Code') }}" />
                                            </div>
                                            @error('coupon_code')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="validity_from">{{ __('Valid From') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="validity_from" name="validity_from" class="form-control"
                                                    value="{{ $coupon->validity_from }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="validity_to">{{ __('Valid To') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="validity_to" name="validity_to" class="form-control"
                                                    value="{{ $coupon->validity_to }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="coupon_type">{{ __('Coupon Type') }} <span class="text-danger">*</span></label>
                                                <select id="coupon_type" name="coupon_type" class="form-control">
                                                    <option value="percent" @if ($coupon->coupon_type === 'percent') selected @endif>Percentage</option>
                                                    <option value="amount" @if ($coupon->coupon_type === 'amount') selected @endif>Amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="amount">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" id="amount" name="amount" class="form-control" value="{{ $coupon->amount }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="usability">{{ __('Usability') }} <span class="text-danger">*</span></label>
                                                <div class="input-group mb-3">
                                                    <select id="usability_options" name="usability" class="form-control w-50">
                                                        <option value="1" @if ($coupon->usability === 1) selected @endif>Default</option>
                                                        <option value="9999" @if ($coupon->usability === 9999) selected @endif>Unlimited</option>
                                                        <option value="other" @if (!in_array($coupon->usability, [1, 9999])) selected @endif>Other</option>
                                                    </select>
                                                    <input type="text" id="usability" id="usability" name="usability" class="form-control"
                                                    @if (in_array($coupon->usability, [1, 9999])) disabled @endif />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="status">{{ __('Status') }} <span class="text-danger">*</span></label>
                                                <select id="status" name="status" class="form-control">
                                                    <option value="1" @if ($coupon->status === 1) selected @endif>Active</option>
                                                    <option value="0" @if ($coupon->status === 0) selected @endif>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <a href="{{ route('admin.coupon.index') }}" class="btn">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                $('#validity_to').datepicker('option', 'minDate', date2);
            }
        });

        $("#validity_to").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            minDate: $('#validity_from').datepicker('getDate'),
        });
    });

    $(document).ready(function () {

        if ($('#usability_options').val() === 'other') {
            $('#usability').val({{ $coupon->usability }}).prop('disabled', false);
        } else {
            $('#usability').val({{ $coupon->usability }}).prop('disabled', true);
        }

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
        isUserSpecifyDropdown.on('change', function() {
            if (isUserSpecifyDropdown.val() === '1') {
                userSpecifyDropdown.show();
            } else {
                userSpecifyDropdown.hide();
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
