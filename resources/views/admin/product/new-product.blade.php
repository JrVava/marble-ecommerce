@php
    $route = route('products.save');
    if (isset($product->id)) {
        $route = route('products.update');
    }
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', ' Product - Add')
@section('breadcrumb')
    <h4 class="py-3 mb-4">
        <a href="#">
            <span class="text-muted fw-light">
                Products
            </span>
        </a>
        <span class="text-muted fw-light">
            /Add Product
        </span>
    </h4>
@endsection
@section('content')
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .image-preview img {
            max-width: 100px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .image-preview .remove-icon {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff0000;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            cursor: pointer;
        }

        /* Hide the file input */
        #fileUpload {
            display: none;
        }

        /* Style the plus icon box */
        #fileUploadButton {
            font-size: 40px;
            cursor: pointer;
            display: inline-block;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 25px;
            color: #007bff;
            background-color: #fff;
            text-align: center;
            line-height: 1;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            /* Space between the icon and preview */
        }

        /* Add hover effect for the button */
        #fileUploadButton:hover {
            background-color: #007bff;
            color: #fff;
        }

        #previewContainer {
            border: dotted;
            padding: 12px;
            margin: 14px;
            border-radius: 11px;
            border-color: #3c63cd;
        }
    </style>
    <!-- Basic Layout -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>
    @endif
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product</h5> <small class="text-muted float-end">New Product</small>
                </div>
                <div class="card-body">
                    <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($product->id))
                            <input type="hidden" name="id" value="{{ $product->id }}">
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                placeholder="Enter Product Name"
                                value="{{ isset($product->product_name) ? $product->product_name : old('product_name') }}" />
                            @error('product_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sku">SKU</label>
                            <input type="text" class="form-control" name="sku" id="sku"
                                value="{{ isset($product->sku) ? $product->sku : old('sku') }}" placeholder="Enter SKU" />
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="product_origin">Product Origin</label>
                            <input type="text" class="form-control" id="product_origin" name="product_origin"
                                placeholder="Enter Product Origin"
                                value="{{ isset($product->product_origin) ? $product->product_origin : old('product_origin') }}" />
                            @error('product_origin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="thickness">Product Thickness</label>
                            <input type="text" class="form-control" id="thickness" name="thickness"
                                placeholder="Enter Product Thickness"
                                value="{{ isset($product->thickness) ? $product->thickness : old('thickness') }}" />
                            @error('thickness')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product_height">Product Height</label>
                            <input type="text" class="form-control" id="product_height" name="product_height"
                                placeholder="Enter Product Height"
                                value="{{ isset($product->product_height) ? $product->product_height : old('product_height') }}" />
                            @error('product_height')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product_width">Product Width</label>
                            <input type="text" class="form-control" id="product_width" name="product_width"
                                placeholder="Enter Product Width"
                                value="{{ isset($product->product_width) ? $product->product_width : old('product_width') }}" />
                            @error('product_width')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="shape">Product shape</label>
                            <input type="text" class="form-control" id="shape" name="shape"
                                placeholder="Enter Product Shape"
                                value="{{ isset($product->shape) ? $product->shape : old('shape') }}" />
                            @error('shape')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edges">Product edges</label>
                            <input type="text" class="form-control" id="edges" name="edges"
                                placeholder="Enter Product Edges"
                                value="{{ isset($product->edges) ? $product->edges : old('edges') }}" />
                            @error('edges')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="total_qty">Product total quantity</label>
                            <input type="text" class="form-control" id="total_qty" name="total_qty"
                                placeholder="Enter Product Total Quantity"
                                value="{{ isset($product->total_qty) ? $product->total_qty : old('total_qty') }}" />
                            @error('total_qty')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="no_of_slabs">Product Total Slabs</label>
                            <input type="text" class="form-control" id="no_of_slabs" name="no_of_slabs"
                                placeholder="Enter Product Total Slabs"
                                value="{{ isset($product->no_of_slabs) ? $product->no_of_slabs : old('no_of_slabs') }}" />
                            @error('no_of_slabs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="rate">Product rate</label>
                            <input type="text" class="form-control" id="rate" name="rate"
                                placeholder="Enter Product Rate"
                                value="{{ isset($product->rate) ? $product->rate : old('rate') }}" />
                            @error('rate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="discount">Product discount</label>
                            <input type="text" class="form-control" id="discount" name="discount"
                                placeholder="Enter Product Discount"
                                value="{{ isset($product->discount) ? $product->discount : old('discount') }}" />
                            @error('discount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Product Description</label>
                            <textarea id="description" class="form-control" name="description" placeholder="Enter Product Description">{{ isset($product->description) ? $product->description : old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Choose Files</label>
                            <div class="file-upload-container">
                                <!-- Hidden file input -->
                                <input type="file" id="fileUpload" class="form-control" name="images[]" multiple
                                    accept="image/*">
                                <!-- Box with the plus icon -->
                                <div id="fileUploadButton">
                                    <i class="bx bx-plus"></i>
                                </div>
                                <!-- Preview Container -->
                                <div id="previewContainer" class="d-flex flex-wrap">
                                    @if (isset($product->images) && count($product->images) > 0)
                                        @foreach ($product->images as $images)
                                            <div class="image-preview" data-index="{{ $images->id }}">
                                                <img src="{{ Storage::url('/product_images/' . $images->product_id . '/' . $images->image) }}"
                                                    alt="Image Preview">
                                                <div class="remove-icon">&times;</div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#description'), {
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}',
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            $('#product_name').keyup(function() {
                let inputValue = this.value;
                let sanitizedValue = sanitizeText(inputValue);
                $('#sku').val(`${sanitizedValue}`);
            })

            function sanitizeText(inputText) {
                var sanitizedText = inputText.replace(/[^\w\s]/gi, '');
                sanitizedText = sanitizedText.replace(/\s+/g, '-');
                sanitizedText = sanitizedText.replace(/\//g, ''); // Exclude forward slash
                sanitizedText = sanitizedText.toLowerCase();
                return sanitizedText;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            if ($("#previewContainer").find('.image-preview').length > 0) {
                $("#previewContainer").css({
                    'border': '',
                    'padding': '',
                    'margin': '',
                    'border-radius': '',
                    'border-color': ''
                })
            }
            // Trigger file input when clicking the plus icon box
            $('#fileUploadButton').on('click', function() {
                $('#fileUpload').click();
            });

            // Store the selected files temporarily
            let selectedFiles = [];

            // Handle file selection
            $('#fileUpload').on('change', function() {
                const files = this.files;
                selectedFiles = Array.from(files); // Store selected files

                // Clear existing previews
                // $('#previewContainer').empty();

                // Create previews for each selected file
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageHtml = `
              <div class="image-preview" data-index="${index}">
                <img src="${e.target.result}" alt="Image Preview">
                <div class="remove-icon">&times;</div>
              </div>`;
                        $('#previewContainer').append(imageHtml);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Remove the image preview and the corresponding file from the input
            $(document).on('click', '.remove-icon', function() {
                const preview = $(this).closest('.image-preview');
                const index = preview.data('index'); // Get the index of the image to be removed

                // Remove the preview from the UI
                preview.remove();

                // Remove the file from the selectedFiles array
                selectedFiles.splice(index, 1);

                // Create a new DataTransfer object to update the file input
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));

                // Update the file input with the new file list
                $('#fileUpload')[0].files = dataTransfer.files;
            });
        });
    </script>
@endsection
