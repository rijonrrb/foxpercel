@extends('admin.layouts.master')
@section('order', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])

@php
    $order = $data['order'] ?? [];
@endphp

@push('style')
    <style>
        .progress_container {
            width: 350px;
            display: flex;
            justify-content: space-between;
            margin: 2rem auto;
            position: relative;
        }

        .progress_container::before {
            content: "";
            background-color: #cdcdcd;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            z-index: 1;
        }

        .progress {
            background-color: #61bf24;
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 0%;
            z-index: 1;
            transition: 0.4s ease-in;
        }

        .circle {
            background-color: #dfdfdf;
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            z-index: 1;
            transition: 0.4s ease;
            font-size: 16px;
            border: 1px solid white;
        }

        .circle.active {
            border-color: #ffffff;
            color: white;
            background-color: #61bf24;
        }

        fieldset {
            border: 1px dotted #bcb3b6;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 10px;
            padding-left: 12px;
        }

        legend {
            float: none;
            width: inherit;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: 500;
            color: #92a9c9;
        }

        .delete-fieldset {
            top: -40px !important;
            background: #ff6262;
            color: white;
            padding: 0px 5px;
            border: 0px;
            border-radius: 100%;
        }
    </style>
    @if (isset($order->step) && $order->step == 2)
        <style>
            .progress {
                width: 50% !important;
            }
        </style>
    @elseif (isset($order->step) && $order->step == 3)
        <style>
            .progress {
                width: 100% !important;
            }
        </style>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

            .box-right {
                padding: 30px 25px;
                background-color: #f5f7ff;
                border-radius: 15px;
            }

            .box-left {
                padding: 20px 20px;
                background-color: #f5f5f5;
                border-radius: 15px;
            }

            .textmuted {
                color: #7a7a7a;
            }

            .p-blue {
                font-size: 14px;
                color: #1976d2;
            }

            .fas.fa-circle {
                font-size: 12px;
            }

            .p-org {
                font-size: 14px;
                color: #fbc02d;
            }

            .h7 {
                font-size: 15px;
            }

            .h8 {
                font-size: 12px;
            }

            .h9 {
                font-size: 10px;
            }

            .bg-blue {
                background-color: #dfe9fc9c;
                border-radius: 5px;
            }

            .card input::placeholder {
                font-size: 14px;
            }

            ::placeholder {
                font-size: 14px;
            }

            .cursor {
                cursor: pointer;
            }

            @media(max-width:320px) {
                .h8 {
                    font-size: 11px;
                }

                .h7 {
                    font-size: 13px;
                }

                ::placeholder {
                    font-size: 10px;
                }
            }
        </style>
    @endif
@endpush

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="progress_container mb-4">
                    <div class="progress" id="progress"></div>
                    <div class="circle active">1</div>
                    <div class="circle @if ($data['order']->step == 2 || $data['order']->step == 3) active @endif">2</div>
                    <div class="circle @if ($data['order']->step == 3) active @endif">3</div>
                </div>

                <!-- Percel Information (Step 1) -->
                <div class="card" id="step1">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Item Information</h4>
                                <button type="button" class="btn btn-success" id="add-item">Add Item</button>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.order.update', $data['order']->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="step" id="step" value="1">
                                    <div class="dynamic_div">
                                        @foreach ($data['items'] as $key => $item)
                                            <input type="hidden" name="item_id[]" id="item_id"
                                                value="{{ $item->id }}">
                                            <input type="hidden" name="item_image_url[]" id="item_image_url"
                                                value="{{ $item->image }}">
                                            <input type="hidden" name="item_prescription_url[]" id="item_prescription_url"
                                                value="{{ $item->prescription }}">
                                            <fieldset class="form-group p-3 mb-3 position-relative">
                                                <legend class="w-auto px-2">Item {{ $key + 1 }}</legend>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <span class="preview avatar avatar-xl"
                                                                    style="background-image: url('{{ getPhoto($item->image) }}');"></span>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javascript:void(0)" class="btn changeAvatarBtn">
                                                                    Upload Item Image
                                                                </a>
                                                                <input type="file" name="item_image[]" class="image"
                                                                    accept="image/*" hidden>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-md-12 mb-3">
                                                <label for="item_image" class="form-label">Upload Item Image</label>
                                                <input type="file" name="item_image[]" class="form-control">
                                                <small>Existing Image: <img src="{{ asset($item->image) }}" alt="Item Image" width="50"></small>
                                            </div> --}}

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_category" class="form-label">Item Category</label>
                                                        <select name="item_category_id[]" id="item_category"
                                                            class="form-select select2" required>
                                                            <option value="" class="d-none">Select Category</option>
                                                            @foreach ($data['categories'] as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $item->item_category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_name" class="form-label">Item Name</label>
                                                        <input type="text" name="item_name[]" class="form-control"
                                                            value="{{ $item->item_name }}" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_price" class="form-label">Item Price</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="item_price[]"
                                                                class="form-control w-50" value="{{ $item->item_price }}"
                                                                required>
                                                            <select name="currency[]" class="form-select select2" required>
                                                                <option value="" class="d-none">Select Currency</option>
                                                                @foreach ($data['currencies'] as $currency)      
                                                                    <option value="{{$currency->symbol}}"
                                                                        {{ $item->currency == $currency->symbol ? 'selected' : '' }}>{{$currency->symbol}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_weight" class="form-label">Item Weight
                                                            (lbs)</label>
                                                        <input type="number" step="0.01" name="item_weight[]"
                                                            id="item_weight" class="form-control" placeholder="Item Weight"
                                                            value="{{ $item->item_weight }}" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_color" class="form-label">Item Color</label>
                                                        <input type="text" name="item_color[]" id="item_color"
                                                            class="form-control" placeholder="Item Color"
                                                            value="{{ $item->item_color }}" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_size" class="form-label">Item Size</label>
                                                        <input type="text" name="item_size[]" id="item_size"
                                                            class="form-control" placeholder="Item Size"
                                                            value="{{ $item->item_size }}" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3" id="item_model_div"
                                                        style="display: {{ $item->item_category_id == 'medicine' ? 'block' : 'none' }};">
                                                        <label for="item_model" class="form-label">Item Model</label>
                                                        <input type="text" name="item_model[]" id="item_model"
                                                            class="form-control" placeholder="Item Model"
                                                            value="{{ $item->item_model }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_quantity" class="form-label">Item
                                                            Quantity</label>
                                                        <input type="number" name="item_quantity[]" class="form-control"
                                                            value="{{ $item->item_quantity }}" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_link" class="form-label">Item Link</label>
                                                        <input type="url" name="item_link[]" id="item_link"
                                                            class="form-control" placeholder="Item Link/URL"
                                                            value="{{ $item->item_link }}" required>
                                                    </div>

                                                    <div class="col-md-12 mb-3" id="prescription_upload"
                                                        style="display: {{ $item->item_category_id == 'medicine' ? 'block' : 'none' }};">
                                                        <label for="prescription" class="form-label">Upload Prescription
                                                            (PDF/DOC)</label>
                                                        <input type="file" name="prescription[]" id="prescription"
                                                            class="form-control">
                                                        <small>Existing Prescription: <a
                                                                href="{{ asset($item->prescription) }}" target="_blank"
                                                                rel="noopener noreferrer">prescription.pdf</a></small>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="note" class="form-label">Note</label>
                                                        <textarea name="note[]" id="note" cols="30" rows="5" class="form-control"
                                                            placeholder="Enter any additional notes or instructions">{{ $item->note }}</textarea>
                                                    </div>
                                                </div>

                                                @if ($key > 0)
                                                    <button type="button"
                                                        class="btn btn-secondary position-absolute end-0 m-2 delete-fieldset"
                                                        aria-label="Close">X</button>
                                                @endif
                                            </fieldset>
                                        @endforeach
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4">
                                        <button type="submit" class="btn btn-primary">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information (Step 2) -->
                <div class="card" id="step2">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Order Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.order.update', $data['order']->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="step" id="step" value="2">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="shopping_country" class="form-label">Shopping From Country</label>
                                            <select name="shopping_country" id="shopping_country"
                                                class="form-select select2" required>
                                                <option value="">Select Country</option>
                                                @foreach ($data['countries'] as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $data['order']->shopping_from_country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="delivery_country" class="form-label">Delivery Country</label>
                                            <select name="delivery_country" id="delivery_country"
                                                class="form-select select2" required>
                                                <option value="">Select Country</option>
                                                @foreach ($data['countries'] as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $data['order']->delivery_country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="total_gross_weight" class="form-label">Total Gross Weight
                                                (lbs)</label>
                                            <input type="number" step="0.01" name="total_gross_weight"
                                                value="{{ $data['order']->total_gross_weight }}" id="total_gross_weight"
                                                class="form-control disabled" placeholder="0.00 lbs">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="total_dimension_weight" class="form-label">Total Dimension Weight
                                                (lbs)</label>
                                            <input type="number" step="0.01" name="total_dimension_weight"
                                                value="{{ $data['order']->total_dimension_weight }}"
                                                id="total_dimension_weight" class="form-control" placeholder="0.00 lbs"
                                                required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="total_items" class="form-label">Total Items</label>
                                            <input type="number" name="total_items" id="total_items"
                                                value="{{ $data['order']->total_item }}" class="form-control disabled"
                                                placeholder="Total Items">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="total_amount" class="form-label">Total Item Cost</label>
                                            <input type="number" name="total_amount" id="total_amount"
                                                value="{{ $data['order']->total_amount }}" class="form-control disabled"
                                                placeholder="Total Item Cost">
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary" id="backStep2">Back</button>
                                        <button type="submit" class="btn btn-primary">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Overview (Step 3) -->
                <div class="card" id="step3">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Order Overview</h4>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-secondary me-2" id="backStep3"
                                        style="display: none;">Back</button>
                                    <button class="btn btn-info">Print Invoice</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row m-0">
                                    <div class="col-md-7 col-12">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                @foreach ($data['items'] as $key => $item)
                                                    <div class="row box-right align-items-center mb-4">
                                                        <div class="col-md-4 ps-0">
                                                            <p class="text-muted fw-bold h6 mb-0">Item {{ $key + 1 }}
                                                            </p>
                                                            <p class="h2 fw-bold">
                                                                {{ $item->item_name }} <br>
                                                                <small class="h5">
                                                                    <a href="{{ $item->item_link }}" target="_blank"
                                                                        rel="noopener noreferrer" class="text-primary">
                                                                        Click to view the item
                                                                    </a>
                                                                </small>
                                                            </p>
                                                            <span
                                                                class="text-muted pe-1 h6 align-text-top mt-1">{{ $item->currency }}</span>{{ number_format($item->item_price, 2) }}
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row gy-4 row-cols-2 row-cols-md-3">
                                                                <div
                                                                    class="col specification-item d-flex align-items-center">
                                                                    <div class="icon me-3">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  
                                                                            stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon-tabler icons-tabler-outline icon-tabler-weight">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                            <path d="M6.835 9h10.33a1 1 0 0 1 .984 .821l1.637 9a1 1 0 0 1 -.984 1.179h-13.604a1 1 0 0 1 -.984 -1.179l1.637 -9a1 1 0 0 
                                                                            1 .984 -.821z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="specification-item-cont">
                                                                        <h6 class="specification-item-title mb-0">Gross
                                                                            Weight:</h6>
                                                                        <span>{{ number_format($item->item_weight, 2) }}
                                                                            lbs</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col specification-item d-flex align-items-center">
                                                                    <div class="icon me-3">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  
                                                                            stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  
                                                                            stroke-linejoin="round"  class="icon-tabler icons-tabler-outline icon-tabler-dimensions">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5h11" /><path d="M12 7l2 -2l-2 -2" />
                                                                            <path d="M5 3l-2 2l2 2" /><path d="M19 10v11" /><path d="M17 19l2 2l2 -2" /><path d="M21 12l-2 -2l-2 2" />
                                                                            <path d="M3 10m0 2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="specification-item-cont">
                                                                        <h6 class="specification-item-title mb-0">Dimension
                                                                            Weight:</h6>
                                                                        <span>{{ number_format(0, 2) }} lbs</span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col specification-item d-flex align-items-center">
                                                                    <div class="icon me-3">
                                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  
                                                                            fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  
                                                                            class="icon-tabler icons-tabler-outline icon-tabler-stack-3"><path stroke="none" d="M0 0h24v24H0z" 
                                                                            fill="none"/><path d="M12 2l-8 4l8 4l8 -4l-8 -4" /><path d="M4 10l8 4l8 -4" /><path d="M4 18l8 4l8 -4" />
                                                                            <path d="M4 14l8 4l8 -4" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="specification-item-cont">
                                                                        <h6 class="specification-item-title mb-0">Quantity:
                                                                        </h6>
                                                                        <span>{{ $item->item_quantity }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-12 px-0 mb-4">
                                                <div class="box-right">
                                                    <div class="d-flex pb-2">
                                                        <p class="fw-bold h7">
                                                            <span class="textmuted">Delivery Information
                                                        </p>
                                                    </div>
                                                    <div class="p-2">
                                                        <p class="h4">
                                                            From {{$data['order']->shopping_from_country}} to {{$data['order']->delivery_country}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12 ps-md-5 p-0 ">
                                        <div class="box-left">
                                            <p class="fw-bold h7">{{ auth()->user()->name }}</p>
                                            <p class="textmuted h8">{{ auth()->user()->address }}</p>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Items</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['items'] as $key => $item)
                                                        <tr>
                                                            <td>{{ $item->item_name }}</td>
                                                            <td>{{ $item->item_quantity }}</td>
                                                            <td>{{ $item->currency }}{{ $item->item_price }}</td>
                                                            <td>{{ $item->currency }}{{ number_format($item->item_quantity * $item->item_price, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex h4 mb-1 px-2">
                                                <p class="">Total Amount</p>
                                                <p class="ms-auto">
                                                    {{ $item->currency }}{{ number_format($data['order']->total_amount, 2) }}
                                                </p>
                                            </div>
                                            <div class="d-flex h4 mb-1 px-2">
                                                <p class="">Shipping Charge</p>
                                                <p class="ms-auto">
                                                    ${{ number_format($data['order']->shipping_amount, 2) }}
                                                </p>
                                            </div>
                                            @php
                                                $grand_total =
                                                    $data['order']->total_amount +
                                                    $data['order']->shipping_amount;
                                            @endphp
                                            <div class="d-flex h4 mb-1 px-2">
                                                <p class="">Grand Total</p>
                                                <p class="ms-auto">
                                                    {{ $item->currency }}{{ number_format($grand_total, 2) }}
                                                </p>
                                            </div>
                                            <div class="coupon my-3">
                                                <label class="form-label text-muted mb-2">Have a Coupon Code?</label>
                                                <div class="input-group">
                                                    <input class="form-control" id="paymentCouponCode"
                                                        placeholder="Enter Coupon Code" name="coupon_code" type="text"
                                                        style="height: 40px !important;">
                                                    <span
                                                        class="btn input-group-text py-2 text-white apply-coupon-code-btn btn-success "
                                                        id="applyCouponCodeBtn" data-plan-price="84"
                                                        style="height: 40px !important;"> Apply </span>
                                                </div>
                                            </div>
                                            <div class="row d-flex mt-4">
                                                {{-- <div class="col-md-12 mb-3">
                                                    <h3 class="px-1 mb-0">Choose your payment method :</h3>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-selectgroup-item flex-fill">
                                                        <input type="radio" name="payment_gateway_id" value="1"
                                                            checked="" class="form-selectgroup-input ">
                                                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                            <div class="me-3">
                                                                <span class="form-selectgroup-check"></span>
                                                            </div>
                                                            <div>
                                                                <span class="payment payment-provider-paypal me-2"></span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-selectgroup-item flex-fill">
                                                        <input type="radio" name="payment_gateway_id" value="2"
                                                            checked="" class="form-selectgroup-input ">
                                                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                            <div class="me-3">
                                                                <span class="form-selectgroup-check"></span>
                                                            </div>
                                                            <div>
                                                                <span class="payment payment-provider-stripe me-2"></span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div> --}}
                                                <div class="btn btn-primary d-block h8">Submit
                                                    <span class="ms-3 fas fa-arrow-right"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script>
        let itemCount = 1;

        function handleItemCategoryChange(selectElement) {
            const parentFieldset = selectElement.closest('fieldset');
            const prescriptionField = parentFieldset.querySelector('.prescription_upload');
            const itemModelField = parentFieldset.querySelector('.item_model_div');

            if (selectElement.value === 'medicine') {
                prescriptionField.style.display = 'block';
                itemModelField.style.display = 'block';
            } else {
                prescriptionField.style.display = 'none';
                itemModelField.style.display = 'none';
            }
        }

        function attachItemCategoryEventListeners() {
            document.querySelectorAll('.dynamic_div fieldset select[name="item_category_id[]"]').forEach(selectElement => {
                selectElement.addEventListener('change', function() {
                    handleItemCategoryChange(this);
                });
            });
        }

        function attachDeleteListeners() {
            document.querySelectorAll('.delete-fieldset').forEach(button => {
                button.addEventListener('click', function() {
                    const fieldset = this.closest('fieldset');
                    fieldset.remove();
                    if (itemCount != 1) {
                        itemCount--;
                    }
                    renumberFieldsets();
                });
            });
        }

        function renumberFieldsets() {
            document.querySelectorAll('.dynamic_div fieldset').forEach((fieldset, index) => {
                const legend = fieldset.querySelector('legend');
                if (legend) {
                    legend.textContent = 'Item ' + (index + 1);
                }
            });
        }

        function attachImageUploadEventListeners() {
            document.querySelectorAll('.changeAvatarBtn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const imageInput = button.nextElementSibling;
                    imageInput.click();
                });
            });

            document.querySelectorAll('.image').forEach(function(input) {
                input.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        const preview = input.closest('.row').querySelector('.preview');
                        reader.onload = function(e) {
                            preview.style.backgroundImage = `url(${e.target.result})`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        }

        document.getElementById('add-item').addEventListener('click', function() {
            itemCount++;

            const dynamicDiv = document.querySelector('.dynamic_div');
            let newFieldset = document.querySelector('fieldset').cloneNode(true);
            newFieldset.querySelector('legend').textContent = 'Item ' + itemCount;

            // Reset all fields in the cloned fieldset
            newFieldset.querySelectorAll('input, select, textarea').forEach(field => {
                field.value = '';
            });

            // Reset preview image for the newly cloned fieldset
            const newPreview = newFieldset.querySelector('.preview');
            newPreview.style.backgroundImage = `url('')`; // Reset preview

            // Add delete button to the new fieldset
            let deleteButton = document.createElement('button');
            deleteButton.setAttribute('type', 'button');
            deleteButton.classList.add('btn', 'btn-secondary', 'position-absolute', 'end-0', 'm-2',
                'delete-fieldset');
            deleteButton.setAttribute('aria-label', 'Close');
            deleteButton.textContent = 'X';
            newFieldset.appendChild(deleteButton);

            dynamicDiv.appendChild(newFieldset);

            // Reattach event listeners for the newly added fieldset
            attachItemCategoryEventListeners();
            attachDeleteListeners();
            attachImageUploadEventListeners(); // Add image upload functionality to the newly cloned item
        });

        // Initial event listeners on page load
        attachItemCategoryEventListeners();
        attachDeleteListeners();
        attachImageUploadEventListeners();
    </script>
    <script>
        let step = {{ $data['order']->step }};
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const progress = document.getElementById('progress');
        const circles = document.querySelectorAll('.circle');
        const backStep1 = document.getElementById('backStep1');
        const backStep2 = document.getElementById('backStep2');
        const backStep3 = document.getElementById('backStep3');

        function update() {
            progress.style.width = (step - 1) / (circles.length - 1) * 100 + '%';

            if (step === 1) {
                step1.classList.remove('d-none');
                step2.classList.add('d-none');
                step3.classList.add('d-none');
                backStep1.style.display = 'none';
            } else if (step === 2) {
                step1.classList.add('d-none');
                step2.classList.remove('d-none');
                step3.classList.add('d-none');
                backStep1.style.display = 'block';
            } else if (step === 3) {
                step1.classList.add('d-none');
                step2.classList.add('d-none');
                step3.classList.remove('d-none');
                backStep3.style.display = 'block';
            }
        }


        backStep2.addEventListener('click', (e) => {
            e.preventDefault();
            step = 1;
            update();
        });

        backStep3.addEventListener('click', (e) => {
            e.preventDefault();
            step = 2;
            update();
        });
        update();
    </script>
@endpush
