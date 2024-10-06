<form action="{{ route('admin.category.update', $category->id) }}" method="post">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Category name" required
                value="{{ $category->name }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control form-select">
                <option value="1" {{ $category->status == 1? "selected" : "" }}>Published</option>
                <option value="0" {{ $category->status == 0? "selected" : "" }}>Unpublished</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
        <button type="submit" class="btn btn-success ms-auto">Update</button>
    </div>
</form>
