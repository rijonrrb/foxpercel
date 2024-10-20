@extends('admin.layouts.master')
@section('currency', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection
@section('nav_menu', $data['title'])
@push('style')
@endpush

@section('content')
    <div class="container-xl">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Manage Information</h4>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addCurrencyModal"
                                    class="btn btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTables" class="table table-hover text-nowrap jsgrid-table">
                                        <thead>
                                            <tr>
                                                <th width="5%">SN</th>
                                                <th width="25%">Currency Name</th>
                                                <th width="25%">Currency Code</th>
                                                <th width="25%">Currency Symbol</th>
                                                <th width="25%">Status</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['rows'] as $key => $row)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->code }}</td>
                                                    <td>{{ $row->symbol }}</td>
                                                    <td>                                              
                                                        @if ($row->status == 1)
                                                            <span class="badge bg-success text-white">Active</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-secondary edit btn-sm"
                                                            data-id="{{ $row->id }}">Edit</a>
                                                        <a href="{{ route('admin.currency.delete', $row->id) }}"
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

    {{-- create modal --}}
    <div class="modal modal-blur fade" id="addCurrencyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addCurrencyModalLabel">Add Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form -->
                <form action="{{ route('admin.currency.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Currency Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Currency name" required>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Currency Code</label>
                            <input type="text" name="code" id="code" class="form-control"
                                placeholder="Currency code" required>
                        </div>

                        <div class="mb-3">
                            <label for="symbol" class="form-label">Currency Symbol</label>
                            <input type="text" name="symbol" id="symbol" class="form-control"
                                placeholder="Currency Symbol" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-success ms-auto">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit modal --}}
    <div class="modal modal-blur fade" id="editCurrencyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editCurrencyModalLabel">Edit Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div id="modal_body"></div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).on('click', '.edit', function() {
            let cat_id = $(this).data('id');
            $.get('currency/' + cat_id + '/edit', function(data) {
                console.log(data);
                $('#editCurrencyModal').modal('show');
                $('#modal_body').html(data);
            });
        });
    </script>
@endpush
