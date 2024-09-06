@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/blog_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thêm</li>
                </ol>
            </nav>
        </div>
    </div>
    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Tiêu đề" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mb-3">
                    <label for="isFeatured" class="form-label">Hành động</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="isFeatured" name="isFeatured" value="1">
                        <label class="form-check-label" for="isFeatured">is Feature</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Lưu</button>
                    <button type="submit" class="btn btn-secondary mt-2">Lưu & thoát</button>
                </div>
                <div class="mb-3">
                    <label for="categories" class="form-label">Chuyên mục</label>
                    <div>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="category{{ $category->id }}"
                                    name="categories[]" value="{{ $category->id }}">
                                <label class="form-check-label" for="category{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1">Đã xuất bản</option>
                        <option value="0">Bản nháp</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="featured_image" class="form-label">Ảnh đại diện</label>
                    <input type="hidden" id="featured_image" name="featured_image" class="form-control" aria-label="Image"
                        aria-describedby="ckfinder-button">
                    <img id="image-preview" src="<?php echo asset('storage/images/default-image.png'); ?>" alt="Ảnh đại diện" class="img-thumbnail mt-2"
                        style="width: 100%; height:200px; cursor: pointer;">
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label">Tag</label>
                    <select class="form-control" id="tags" name="tags[]" multiple="multiple">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#modal-add-tag">+
                        Thêm</button>
                </div>
            </div>
        </div>
    </form>

    @include('blog.modal_add_tag')
@endsection
@section('scripts')
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
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
    <script>
        document.getElementById('image-preview').onclick = function() {
            CKFinder.popup({
                chooseFiles: true,
                onInit: function(finder) {
                    finder.on('files:choose', function(evt) {
                        var file = evt.data.files.first();
                        var imageUrl = file.getUrl();
                        document.getElementById('featured_image').value = imageUrl;
                        document.getElementById('image-preview').src = imageUrl;
                    });
                    finder.on('file:choose:resizedImage', function(evt) {
                        var resizedImageUrl = evt.data.resizedUrl;
                        document.getElementById('featured_image').value = resizedImageUrl;
                        document.getElementById('image-preview').src = resizedImageUrl;
                    });
                }
            });
        };
    </script>
@endsection
