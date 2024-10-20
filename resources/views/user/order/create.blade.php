@extends('user.layouts.master')
@section('order-create', 'active')
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
                                <button type="button" class="btn btn-success" id="add-item">Add Item</button>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.order.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dynamic_div">
                                        @php $itemIndex = 0; @endphp
                                        @foreach (old('item_category_id', ['']) as $key => $oldCategory)
                                            <fieldset class="form-group p-3 mb-3 position-relative">
                                                <legend class="w-auto px-2">Item {{ $key + 1 }}</legend>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <span class="preview avatar avatar-xl" style="background-image: url('{{ getPhoto('') }}');"></span>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="javascript:void(0)" class="btn changeAvatarBtn">
                                                                    Upload Item Image
                                                                </a>
                                                                <input type="file" name="item_image[]" class="image" accept="image/*" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-12 mb-3">
                                                        <label for="item_image" class="form-label">Upload Item Image <span
                                                                data-bs-toggle="tooltip" data-bs-html="true"
                                                                title="Recommended image size: 500x500px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="currentColor"
                                                                    class="icon icon-tabler icons-tabler-filled icon-tabler-help-circle">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 13a1 1 0 0 0 -.993 .883l-.007 .117l.007 .127a1 1 0 0 0 1.986 0l.007 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm1.368 -6.673a2.98 2.98 0 0 0 -3.631 .728a1 1 0 0 0 1.44 1.383l.171 -.18a.98 .98 0 0 1 1.11 -.15a1 1 0 0 1 -.34 1.886l-.232 .012a1 1 0 0 0 .111 1.994a3 3 0 0 0 1.371 -5.673z" />
                                                                </svg>
                                                            </span>
                                                        </label>
                                                        <input type="file" name="item_image[]" id="item_image"
                                                            class="form-control" required>
                                                    </div> --}}
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_category" class="form-label">Item Category</label>
                                                        <select name="item_category_id[]" id="item_category"
                                                            class="form-select select2" required>
                                                            <option value="" class="d-none">Select Category</option>
                                                            @foreach ($data['categories'] as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ old('item_category_id.' . $key) == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_name" class="form-label">Item Name</label>
                                                        <input type="text" name="item_name[]" id="item_name"
                                                            class="form-control" placeholder="Item Name"
                                                            value="{{ old('item_name.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_price" class="form-label">Item Price</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="item_price[]"
                                                                id="item_price" class="form-control w-50"
                                                                placeholder="Item Price"
                                                                value="{{ old('item_price.' . $key) }}" required>
                                                            <select name="currency[]" id="currency"
                                                                class="form-select select2" required>
                                                                <option value="" class="d-none">Select Currency</option>
                                                                @foreach ($data['currencies'] as $currency)      
                                                                    <option value="{{$currency->symbol}}"
                                                                        {{ old('currency.' . $key) == $currency->symbol ? 'selected' : '' }}>{{$currency->symbol}}
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
                                                            value="{{ old('item_weight.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_color" class="form-label">Item Color</label>
                                                        <input type="text" name="item_color[]" id="item_color"
                                                            class="form-control" placeholder="Item Color"
                                                            value="{{ old('item_color.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_size" class="form-label">Item Size</label>
                                                        <input type="text" name="item_size[]" id="item_size"
                                                            class="form-control" placeholder="Item Size"
                                                            value="{{ old('item_size.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3" id="item_model_div"
                                                        style="display: {{ old('item_category_id.' . $key) == 'medicine' ? 'block' : 'none' }};">
                                                        <label for="item_model" class="form-label">Item Model</label>
                                                        <input type="text" name="item_model[]" id="item_model"
                                                            class="form-control" placeholder="Item Model"
                                                            value="{{ old('item_model.' . $key) }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_quantity" class="form-label">Item
                                                            Quantity</label>
                                                        <input type="number" name="item_quantity[]" id="item_quantity"
                                                            class="form-control" placeholder="Item Quantity"
                                                            value="{{ old('item_quantity.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="item_link" class="form-label">Item Link</label>
                                                        <input type="url" name="item_link[]" id="item_link"
                                                            class="form-control" placeholder="Item Link/URL"
                                                            value="{{ old('item_link.' . $key) }}" required>
                                                    </div>
                                                    <div class="col-md-12 mb-3" id="prescription_upload"
                                                        style="display: {{ old('item_category_id.' . $key) == 'medicine' ? 'block' : 'none' }};">
                                                        <label for="prescription" class="form-label">Upload Prescription
                                                            (PDF/DOC)</label>
                                                        <input type="file" name="prescription[]" id="prescription"
                                                            class="form-control">
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="note" class="form-label">Note</label>
                                                        <textarea name="note[]" id="note" cols="30" rows="5" class="form-control"
                                                            placeholder="Enter any additional notes or instructions">{{ old('note.' . $key) }}</textarea>
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
                                    <div class="col-md-12 d-flex justify-content-center mt-4">
                                        <button type="submit" class="btn btn-primary">Next</button>
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
        deleteButton.classList.add('btn', 'btn-secondary', 'position-absolute', 'end-0', 'm-2', 'delete-fieldset');
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
@endpush
