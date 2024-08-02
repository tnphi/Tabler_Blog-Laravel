@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Tổng quan
                        </div>
                        <h2 class="page-title">
                            Tags
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-add-tag">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Thêm Tag mới
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-report" aria-label="Create new report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tất cả Tag</h3>
                            </div>
                            <div class="table-responsive">
                                <table id="tagTable" class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                    type="checkbox" aria-label="Select all invoices"></th>
                                            <th class="w-1">No.
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 15l6 -6l6 6" />
                                                </svg>
                                            </th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th class ="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $index => $tag)
                                            <tr>
                                                <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                        aria-label="Select invoice"></td>
                                                <td><span class="text-secondary">{{ $index + 1 }}</span></td>
                                                <td><a href="#" class="text-reset"
                                                        tabindex="-1">{{ $tag->name }}</a></td>
                                                <td>{{ $tag->description }}</td>
                                                <td>{{ $tag->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $tag->status_badge_color }}">
                                                        {{ $tag->status_label }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-tag-{{ $tag->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('blog_tags.destroy', $tag->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc là muốn xóa dữ liệu này?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Modal for Edit Tag -->
                                            <div class="modal fade" id="modal-edit-tag-{{ $tag->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="modal-edit-tag-label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('blog_tags.update', $tag->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-edit-tag-label">Sửa Tag
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="tag-name-{{ $tag->id }}"
                                                                        class="form-label">Tên Tag</label>
                                                                    <input type="text" class="form-control"
                                                                        id="tag-name-{{ $tag->id }}" name="name"
                                                                        value="{{ $tag->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tag-status-{{ $tag->id }}"
                                                                        class="form-label">Trạng Thái</label>
                                                                    <select class="form-select"
                                                                        id="tag-status-{{ $tag->id }}"
                                                                        name="status" required>
                                                                        @foreach (\App\Enums\BlogStatus::cases() as $status)
                                                                            <option value="{{ $status->value }}"
                                                                                {{ $tag->status == $status->value ? 'selected' : '' }}>
                                                                                {{ $status->label() }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tag-description-{{ $tag->id }}"
                                                                        class="form-label">Mô Tả</label>
                                                                    <textarea class="form-control" id="tag-description-{{ $tag->id }}" name="description" rows="3">{{ $tag->description }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Lưu</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
                                    class="link-secondary" rel="noopener">Documentation</a></li>
                            <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                            <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank"
                                    class="link-secondary" rel="noopener">Source code</a></li>
                            <li class="list-inline-item">
                                <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary"
                                    rel="noopener">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                    </svg>
                                    Sponsor
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright &copy; 2023
                                <a href="." class="link-secondary">Tabler</a>.
                                All rights reserved.
                            </li>
                            <li class="list-inline-item">
                                <a href="./changelog.html" class="link-secondary" rel="noopener">
                                    v1.0.0-beta20
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

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
@endsection
