@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/blog_create.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Quản lý nghỉ phép</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Xin nghỉ phép</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-9">
            <div class="mb-3">
                <label for="title" class="form-label">Loại nghỉ phép</label>
                <select name="loai_nghi_phep" id="loai_nghi_phep" class="form_select" disabled>
                    <option value="1" {{ $leaveRequest->leave_type == 1 ? 'selected' : '' }}>Nghỉ phép</option>
                    <option value="2" {{ $leaveRequest->leave_type == 2 ? 'selected' : '' }}>Làm việc online
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea class="form-control" id="content" name="content" rows="10">
                        {{ $leaveRequest->content }}
                    </textarea>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="mb-3" style="display:flex; flex-direction:column;">
                <label for="isFeatured" class="form-label">Trạng thái</label>
                @if ($leaveRequest->is_confirm == 0)
                    <label class="badge bg-warning" style="width:fit-content;">Chờ phê duyệt</label>
                @elseif($leaveRequest->is_confirm == 1)
                    <label class="badge bg-success" style="width:fit-content;">Đã phê duyệt</label>
                @elseif($leaveRequest->is_confirm == 2)
                    <span class="badge bg-danger" style="width:fit-content;">Đã từ chối</span>
                @endif

                @if ($leaveRequest->is_confirm == 0)
                    <div class="group-but" style="display:flex; gap:10px;">
                        <form method="POST" action="{{ route('dayoff.approve', $leaveRequest->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-primary mt-2" style="width:fit-content;">Phê
                                duyệt</button>
                        </form>

                        <form method="POST" action="{{ route('dayoff.approve', $leaveRequest->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn btn-secondary mt-2" style="width:fit-content;">Từ
                                chối</button>
                        </form>

                    </div>
                @endif

            </div>
            <div class="mb-3">
                <label for="datepicker" class="form-label">Ngày</label>
                <div id="datepicker"></div>
                <!-- Input ẩn để lưu các ngày đã chọn -->
                <input type="hidden" id="leave_dates" name="leave_dates">

            </div>

        </div>
    </div>


    @include('blog.modal_add_tag')
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/plugins/multiselect.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Các ngày nghỉ đã được chọn từ server (PHP)
            let initialDates = @json($leaveDates); // Mảng các ngày từ PHP
            console.log(initialDates);

            const picker = new Litepicker({
                element: document.getElementById('datepicker'),
                plugins: ['multiselect'],
                inlineMode: true,
                format: 'YYYY-MM-DD',
                lang: 'vi-VN',
                highlightedDays: initialDates, // Các ngày đã chọn
                highlightedDaysFormat: 'YYYY-MM-DD',
                setup: (picker) => {
                    picker.on('multiselect.select', (date) => {

                    });

                    picker.on('multiselect.deselect', (date) => {

                    });
                    picker.setOptions({
                        disablePicker: true
                    });
                },
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Chọn hoặc thêm tag mới"
            });
        });
    </script>
    <script type="module">
        import {
            ClassicEditor,
            CKFinder,
            CKFinderUploadAdapter,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph,
            Link,
            List,
            Image,
            ImageToolbar,
            ImageCaption,
            ImageStyle,
            ImageUpload,
            Table,
            TableToolbar,
            BlockQuote,
            Strikethrough,
            Subscript,
            Superscript,
            Code,
            HtmlEmbed,
            Alignment,
        } from 'ckeditor5';

        ClassicEditor
            .create(document.querySelector('#content'), {
                plugins: [
                    Essentials, Bold, Italic, Font, Paragraph, Link, List, Image, ImageToolbar, ImageCaption,
                    ImageStyle, ImageUpload, Table, TableToolbar, BlockQuote, CKFinder, CKFinderUploadAdapter
                ],
                toolbar: {
                    items: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'link', 'bulletedList', 'numberedList', '|',
                        'insertTable', 'blockQuote', 'ckfinder'
                    ]
                },
                image: {
                    toolbar: [
                        'imageTextAlternative', 'toggleImageCaption', 'imageStyle:inline', 'imageStyle:block',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells'
                    ]
                },
                ckfinder: {
                    // Upload the images to the server using the CKFinder QuickUpload command.
                    uploadUrl: '/ckfinder/connector'
                },
                heigth: 500,
            })
            .then(editor => {
                window.editor = editor;
                editor.enableReadOnlyMode("editor");

            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
@endsection
