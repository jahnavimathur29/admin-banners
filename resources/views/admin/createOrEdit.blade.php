@extends('admin::admin.layouts.master')

@section('title', 'Banners Management')

@section('page-title', 'Create Banner')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.banners.index') }}">Manage Banners</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Banner</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Start Banner Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form action="{{ isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}"
                        method="POST" id="bannerForm" enctype="multipart/form-data">
                        @if (isset($banner))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $banner?->title ?? old('title') }}" required>
                                    @error('title')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Sub Title<span class="text-danger">*</span></label>
                                    <input type="text" name="sub_title" class="form-control"
                                        value="{{ $banner?->sub_title ?? old('sub_title') }}" required>
                                    @error('sub_title')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Button Title<span class="text-danger">*</span></label>
                                    <input type="text" name="button_title" class="form-control"
                                        value="{{ $banner?->button_title ?? old('button_title') }}" required>
                                    @error('button_title')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button URL<span class="text-danger">*</span></label>
                                    <input type="text" name="button_url" class="form-control"
                                        value="{{ $banner?->button_url ?? old('button_url') }}" required>
                                    @error('button_url')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Sort Order<span class="text-danger">*</span></label>
                                    <input type="text" name="sort_order" class="form-control"
                                        value="{{ $banner?->sort_order ?? old('sort_order') }}" required>
                                    @error('sort_order')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control" id="imageInput" {{ isset($banner) ? '' : 'required' }}>
                                    @error('image')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror

                                    <div id="imagePreview" style="margin-top:10px;">
                                        @if(isset($banner) && $banner->image)
                                            <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner Image" style="max-width: 200px; max-height: 120px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control description-editor">{{ $banner?->description ?? old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End banner Content -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS for the page -->
    <link rel="stylesheet" href="{{ asset('backend/custom.css') }}">           
@endpush

@push('scripts')
    <!-- Then the jQuery Validation plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- Include the CKEditor script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <!-- Select2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Initialize CKEditor -->
    <script>
    let ckEditorInstance;

    ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        ckEditorInstance = editor;

        // optional styling
        editor.ui.view.editable.element.style.minHeight = '250px';
        editor.ui.view.editable.element.style.maxHeight = '250px';
        editor.ui.view.editable.element.style.overflowY = 'auto';

        // 🔥 Trigger validation on typing
        editor.model.document.on('change:data', () => {
            const descriptionVal = editor.getData();
            $('#description').val(descriptionVal); // keep textarea updated
            $('#description').trigger('keyup'); // trigger validation manually
        });
    })
    .catch(error => {
        console.error(error);
    });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements with the class 'select2'
            $('.select2').select2();

            //jquery validation for the form
            $('#bannerForm').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        minlength: 3
                    },
                    sub_title: {
                        required: true,
                        minlength: 3
                    },
                    button_title: {
                        required: true,
                        minlength: 3
                    },
                    button_url: {
                        required: true,
                        minlength: 3
                    },
                    sort_order: {
                        required: true,
                        digits: true,
                        min: 0,
                    },
                    description: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters long"
                    },
                    sub_title: {
                        required: "Please enter a sub title",
                        minlength: "Sub title must be at least 3 characters long"
                    },
                    button_title: {
                        required: "Please enter a button title",
                        minlength: "Button title must be at least 3 characters long"
                    },
                    button_url: {
                        required: "Please enter a button URL",
                        minlength: "Button URL must be at least 3 characters long"
                    },
                    sort_order: {
                        required: "Please enter a sort order",
                        digits: "Sort order must be a valid number",
                        min: "Sort order must be at least 0"
                    },
                    description: {
                        required: "Please enter description",
                        minlength: "Description must be at least 3 characters long"
                    }
                },
                submitHandler: function(form) {
                    // Update textarea before submit
                    if (ckEditorInstance) {
                        $('#description').val(ckEditorInstance.getData());
                    }

                    // Now submit
                    form.submit();
                },
                errorElement: 'div',
                errorClass: 'text-danger custom-error',
                errorPlacement: function(error, element) {
                    $('.validation-error').hide(); // hide blade errors
                    if (element.attr("id") === "description") {
                        error.insertAfter($('.ck-editor')); // show below CKEditor UI
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Image preview logic
            $('#imageInput').on('change', function(event) {
                const input = event.target;
                const preview = $('#imagePreview');
                preview.empty(); // Remove old image

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.html('<img src="' + e.target.result + '" style="max-width:200px; max-height:120px;" />');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
@endpush
