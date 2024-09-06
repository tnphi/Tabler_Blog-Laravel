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
    <form action="{{ route('dayoff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Loại nghỉ phép</label>
                    <select name="loai_nghi_phep" id="loai_nghi_phep" class="form_select">
                        <option value="1">Nghỉ phép</option>
                        <option value="2">Làm việc online</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="mb-3">
                    <label for="isFeatured" class="form-label">Hành động</label>
                    <button type="submit" class="btn btn-primary mt-2">Gửi</button>
                </div>
                <div class="mb-3">
                    <label for="datepicker" class="form-label">Ngày</label>
                    <div id="datepicker"></div>
                    <!-- Input ẩn để lưu các ngày đã chọn -->
                    <input type="hidden" id="leave_dates" name="leave_dates">

                </div>

            </div>
        </div>
    </form>

    @include('blog.modal_add_tag')
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/plugins/multiselect.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const picker = new Litepicker({
                element: document.getElementById('datepicker'),
                plugins: ['multiselect'],
                inlineMode: true, // Hiển thị lịch từ đầu/
                format: 'DD/MM/YYYY', // Định dạng ngày (tùy chọn)
                lang: 'vi-VN',
                setup: (picker) => {
                    picker.on('multiselect.select', (date) => {
                        let currentDates = document.getElementById('leave_dates').value;

                        // Nếu đã có giá trị, thêm dấu phẩy và ngày mới, nếu chưa thì thêm trực tiếp ngày
                        if (currentDates) {
                            currentDates += ',' + date.format('YYYY-MM-DD');
                        } else {
                            currentDates = date.format('YYYY-MM-DD');
                        }

                        // Cập nhật giá trị vào input ẩn
                        document.getElementById('leave_dates').value = currentDates;

                        console.log('Updated Dates:', currentDates);
                    });
                    picker.on('multiselect.deselect', (date) => {
                        console.log('Ngày đã bỏ chọn:', date);

                        // Lấy giá trị hiện tại của input ẩn
                        let currentDates = document.getElementById('leave_dates').value.split(
                            ',');

                        // Xóa ngày được bỏ chọn ra khỏi danh sách
                        currentDates = currentDates.filter(d => d !== date.format(
                        'YYYY-MM-DD'));

                        // Cập nhật lại giá trị của input ẩn
                        document.getElementById('leave_dates').value = currentDates.join(',');
                        console.log('Updated Dates after deselect:', currentDates);
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
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
@endsection
