@php
    $route = route('products.save');
    if(isset($product->id)){
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
                        @if(isset($product->id))
                            <input type="hidden" name="id" value="{{$product->id}}">
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name"
                                value="{{ isset($product->product_name) ? $product->product_name : old('product_name') }}" />
                            @error('product_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sku">SKU</label>
                            <input type="text" class="form-control" name="sku" id="sku"
                                value="{{ isset($product->sku) ? $product->sku : old('sku') }}"
                                placeholder="Enter SKU" />
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="product_origin">Product Origin</label>
                            <input type="text" class="form-control" id="product_origin" name="product_origin" placeholder="Enter Product Origin"
                                value="{{ isset($product->product_origin) ? $product->product_origin : old('product_origin') }}" />
                            @error('product_origin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="thickness">Product Thickness</label>
                            <input type="text" class="form-control" id="thickness" name="thickness" placeholder="Enter Product Thickness"
                                value="{{ isset($product->thickness) ? $product->thickness : old('thickness') }}" />
                            @error('thickness')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product_height">Product Height</label>
                            <input type="text" class="form-control" id="product_height" name="product_height" placeholder="Enter Product Height"
                                value="{{ isset($product->product_height) ? $product->product_height : old('product_height') }}" />
                            @error('product_height')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="product_width">Product Width</label>
                            <input type="text" class="form-control" id="product_width" name="product_width" placeholder="Enter Product Width"
                                value="{{ isset($product->product_width) ? $product->product_width : old('product_width') }}" />
                            @error('product_width')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="shape">Product shape</label>
                            <input type="text" class="form-control" id="shape" name="shape" placeholder="Enter Product Shape"
                                value="{{ isset($product->shape) ? $product->shape : old('shape') }}" />
                            @error('shape')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="edges">Product edges</label>
                            <input type="text" class="form-control" id="edges" name="edges" placeholder="Enter Product Edges"
                                value="{{ isset($product->edges) ? $product->edges : old('edges') }}" />
                            @error('edges')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="total_qty">Product total quantity</label>
                            <input type="text" class="form-control" id="total_qty" name="total_qty" placeholder="Enter Product Total Quantity"
                                value="{{ isset($product->total_qty) ? $product->total_qty : old('total_qty') }}" />
                            @error('total_qty')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="no_of_slabs">Product Total Slabs</label>
                            <input type="text" class="form-control" id="no_of_slabs" name="no_of_slabs" placeholder="Enter Product Total Slabs"
                                value="{{ isset($product->no_of_slabs) ? $product->no_of_slabs : old('no_of_slabs') }}" />
                            @error('no_of_slabs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="rate">Product rate</label>
                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Enter Product Rate"
                                value="{{ isset($product->rate) ? $product->rate : old('rate') }}" />
                            @error('rate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="discount">Product discount</label>
                            <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter Product Discount"
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
                            <input class="form-control" type="file" id="fileUpload" name="images[]" multiple>
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
        })
    </script>
@endsection
