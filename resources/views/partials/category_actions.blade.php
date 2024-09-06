<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit-category-{{ $category->id }}">
    <i class="fas fa-edit"></i>
</button>
<form action="{{ route('blog_categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc là muốn xóa dữ liệu này?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

<!-- Modal for Edit Category -->
<div class="modal fade" id="modal-edit-category-{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modal-edit-category-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('blog_categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-category-label">Sửa Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category-name-{{ $category->id }}" class="form-label">Tên Category</label>
                        <input type="text" class="form-control" id="category-name-{{ $category->id }}" name="name"
                            value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category-status-{{ $category->id }}" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="category-status-{{ $category->id }}" name="status" required>
                            @foreach (\App\Enums\BlogStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ $category->status == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category-parent-{{ $category->id }}" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="category-parent-{{ $category->id }}" name="parent_id">
                            <option value="">None</option>
                            @foreach ($category->getParentOptions() as $parentCategory)
                                <option value="{{ $parentCategory->id }}"
                                    {{ $parentCategory->id == $category->parent_id ? 'selected' : '' }}>
                                    {{ $parentCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
