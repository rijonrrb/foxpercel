<form action="{{ route('admin.country.update', $country->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Country Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Country name" required
                value="{{ $country->name }}">
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Country Code</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Country code" required
                value="{{ $country->code }}">
        </div>
    </div>

    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
        <button type="submit" class="btn btn-success ms-auto">Update</button>
    </div>
</form>
