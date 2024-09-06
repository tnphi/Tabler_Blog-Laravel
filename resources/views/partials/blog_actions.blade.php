<a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-warning btn-sm">
    <i class="fas fa-edit"></i>
</a>

<form action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc là muốn xóa dữ liệu này?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
