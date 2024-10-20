<form action="{{ route('admin.currency.update', $currency->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Currency Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Currency Name" required
                value="{{ $currency->name }}">
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Currency Code</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Currency Code" required
                value="{{ $currency->code }}">
        </div>

        <div class="mb-3">
            <label for="symbol" class="form-label">Currency Symbol</label>
            <input type="text" name="symbol" id="symbol" class="form-control" placeholder="Currency Symbol" required
                value="{{ $currency->symbol }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control form-select">
                <option value="1" {{ $currency->status == 1? "selected" : "" }}>Active</option>
                <option value="0" {{ $currency->status == 0? "selected" : "" }}>Inactive</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
        <button type="submit" class="btn btn-success ms-auto">Update</button>
    </div>
</form>
