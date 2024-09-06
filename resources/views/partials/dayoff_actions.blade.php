<form action="{{ route('dayoff.destroy', $leaveRequest->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc là muốn xóa dữ liệu này?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
<a href="{{ route('dayoff.view', $leaveRequest->id) }}" class="btn btn-success btn-sm">
    <i class="fa-solid fa-eye"></i>
</a>
