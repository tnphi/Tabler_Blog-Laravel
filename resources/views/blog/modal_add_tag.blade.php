<div class="modal fade" id="modal-add-tag" tabindex="-1" role="dialog" aria-labelledby="modal-add-tag-label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('blog_tags.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-tag-label">Thêm Tag mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tag-name" class="form-label">Tên Tag</label>
                        <input type="text" class="form-control" id="tag-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="tag-status" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="tag-status" name="status" required>
                            @foreach (\App\Enums\BlogStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tag-description" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="tag-description" name="description" rows="3"></textarea>
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
