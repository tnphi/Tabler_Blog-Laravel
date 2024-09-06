<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit-tag-{{ $tag->id }}">
    <i class="fas fa-edit"></i>
</button>
<form action="{{ route('blog_tags.destroy', $tag->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc là muốn xóa dữ liệu này?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

<!-- Modal for Edit Tag -->
<div class="modal fade" id="modal-edit-tag-{{ $tag->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modal-edit-tag-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('blog_tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-tag-label">Sửa Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tag-name-{{ $tag->id }}" class="form-label">Tên Tag</label>
                        <input type="text" class="form-control" id="tag-name-{{ $tag->id }}" name="name"
                            value="{{ $tag->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tag-status-{{ $tag->id }}" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="tag-status-{{ $tag->id }}" name="status" required>
                            @foreach (\App\Enums\BlogStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ $tag->status == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tag-description-{{ $tag->id }}" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="tag-description-{{ $tag->id }}" name="description" rows="3">{{ $tag->description }}</textarea>
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
