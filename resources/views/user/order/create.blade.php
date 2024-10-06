@extends('user.layouts.master')
@section('order', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])
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
            background-color: #ffffff;
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
    </style>
@endpush

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="progress_container mb-4">
                    <div class="progress" id="progress"></div>
                    <div class="circle active">1</div>
                    <div class="circle">2</div>
                    <div class="circle">3</div>
                </div>
                <!-- Percel Information (Step 1) -->
                <div class="card" id="step1">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Item Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="item_category" class="form-label">Item Category</label>
                                            <select name="item_category_id" id="item_category" class="form-select select2"
                                                required>
                                                <option value="">Select Category</option>
                                                <!-- Add categories here -->
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_name" class="form-label">Item Name</label>
                                            <input type="text" name="item_name" id="item_name" class="form-control"
                                                placeholder="Item Name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_price" class="form-label">Item Price</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="item_price" id="item_price"
                                                    class="form-control" placeholder="Item Price" required style="flex: 7;">
                                                <select name="currency" id="currency" class="form-select select2" required
                                                    style="flex: 3;">
                                                    <option value="">Select Currency</option>
                                                    <!-- Add currencies here -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_weight" class="form-label">Item Weight (lbs)</label>
                                            <input type="number" step="0.01" name="item_weight" id="item_weight"
                                                class="form-control" placeholder="Item Weight" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_color" class="form-label">Item Color</label>
                                            <input type="text" name="item_color" id="item_color" class="form-control"
                                                placeholder="Item Color" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_size" class="form-label">Item Size</label>
                                            <input type="text" name="item_size" id="item_size" class="form-control"
                                                placeholder="Item Size" required>
                                        </div>
                                        <div class="col-md-6 mb-3" id="item_model_div" style="display: none;">
                                            <label for="item_model" class="form-label">Item Model</label>
                                            <input type="text" name="item_model" id="item_model" class="form-control"
                                                placeholder="Item Model">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="item_quantity" class="form-label">Item Quantity</label>
                                            <input type="number" name="item_quantity" id="item_quantity"
                                                class="form-control" placeholder="Item Quantity" required>
                                        </div>

                                        <!-- Prescription upload if medicine is selected -->
                                        <div class="col-md-12 mb-3" id="prescription_upload" style="display: none;">
                                            <label for="prescription" class="form-label">Upload Prescription
                                                (PDF/DOC)</label>
                                            <input type="file" name="prescription" id="prescription"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea name="note" id="note" cols="30" rows="5" 
                                            class="form-control" placeholder="Enter any additional notes or instructions"></textarea>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center mt-4">
                                            <button type="submit" class="btn btn-primary">Next</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information (Step 2) -->
                <div class="card mt-4" id="step2" style="display: none;">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Order Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="shopping_country" class="form-label">Shopping From Country</label>
                                            <select name="shopping_country" id="shopping_country"
                                                class="form-select select2" required>
                                                <option value="">Select Country</option>
                                                <!-- Add countries here -->
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="delivery_country" class="form-label">Delivery Country</label>
                                            <select name="delivery_country" id="delivery_country"
                                                class="form-select select2" required>
                                                <option value="">Select Country</option>
                                                <!-- Add countries here -->
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="total_gross_weight" class="form-label">Total Gross Weight
                                                (lbs)</label>
                                            <input type="number" step="0.01" name="total_gross_weight"
                                                id="total_gross_weight" class="form-control" placeholder="0.00 lbs"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="total_dimension_weight" class="form-label">Total Dimension Weight
                                                (lbs)</label>
                                            <input type="number" step="0.01" name="total_dimension_weight"
                                                id="total_dimension_weight" class="form-control" placeholder="0.00 lbs"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="total_items" class="form-label">Total Items</label>
                                            <input type="number" name="total_items" id="total_items"
                                                class="form-control" placeholder="Total Items" readonly>
                                        </div>

                                        <div class="col-md-12 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success">Next</button>
                                        </div>
                                    </div>
                                </form>
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
        // Show the prescription field if the category is "medicine"
        document.getElementById('item_category').addEventListener('change', function() {
            const prescriptionField = document.getElementById('prescription_upload');
            const itemModelField = document.getElementById('item_model_div');

            if (this.value === 'medicine') {
                prescriptionField.style.display = 'block';
                itemModelField.style.display = 'block';
            } else {
                prescriptionField.style.display = 'none';
                itemModelField.style.display = 'none';
            }
        });
    </script>
@endpush
