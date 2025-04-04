@extends('layouts.frontend-layout')
@section('content')
    <style>
        /* Image Styling */
        .main-image {
            width: 100%;
            min-width: 350px;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
        }

        .image-list {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            max-height: 350px;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .image-list img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border: 1px solid #ddd;
            margin-bottom: 5px;
            transition: transform 0.2s;
        }

        .image-list img:hover {
            transform: scale(1.1);
        }

        /* Product Information */
        .product-title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
        }

        .price {
            font-size: 24px;
            color: #B12704;
            font-weight: bold;
        }

        .stock-status {
            color: green;
            font-weight: bold;
        }

        /* Buttons */
        .buy-btn,
        .cart-btn {
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .buy-btn {
            background-color: #FF9900;
            color: white;
        }

        .cart-btn {
            background-color: #FFD814;
        }

        .buy-btn:hover {
            background-color: #e68900;
        }

        .cart-btn:hover {
            background-color: #e5c100;
        }

        /* Specifications Table */
        .spec-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .spec-table th,
        .spec-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }

        .spec-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .image-checkbox-container {
            position: relative;
            display: inline-block;
        }

        .image-checkbox-container input[type="checkbox"] {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            z-index: 10;
        }

        .image-checkbox-container img {
            display: block;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .image-box-items{
            width: calc(100% / 6 - 14px);
        }
        @media (max-width:991px){
        .image-box-items{
            width: calc(100% / 4 - 14px);
        }
     }
     @media (max-width:767px){
        .image-box-items{
            width: calc(100% / 3 - 14px);
        }
     }

        @media (max-width:540px){
        .image-box-items{
            width: calc(100% / 2 - 10px);
        }
     }
    </style>
    
     <form method="post" action="{{ route('preview-product.send-product-pdf') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="container mt-4">
        <div class="row">
            @if ($product->images->count() > 0)
                <div class="col-md-6 d-flex">
                    <div class="text-center">
                        <img id="mainImage"
                            src="{{ Storage::url('/product_images/' . $product->images[0]->product_id . '/' . $product->images[0]->image) }}"
                            class="main-image">
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <h3 class="product-title">
                    <input type="checkbox" class="detail-checkbox" name="product_checkbox[]" value="product_name">
                    Product: {{ $product->product_name ?? '' }}
                </h3>
                <p>
                    <input type="checkbox" class="detail-checkbox" name="product_checkbox[]" value="sku">
                    <strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}
                </p>           
                <p class="stock-status">
                    <input type="checkbox" class="detail-checkbox" name="product_checkbox[]" value="rate">
                    Price: ₹{{ $product->rate }}
                </p> 
                <p class="price">
                    <input type="checkbox" class="detail-checkbox" name="product_checkbox[]" value="discount">
                     Discount: {{ $product->discount }}%
                </p>
                <p >
                     Mobile Number: <input type="text" class="form-control" name="mobile_number">
                </p>
                {{-- <p>
                    <input type="checkbox" class="detail-checkbox" data-id="{{ $product->id }}" data-label="Brand">
                    <strong>Brand:</strong> XYZ
                </p> --}}
            </div>            
        </div>
        <div class="mt-5">
            <table class="spec-table">
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="product_origin">
                        Product Origin
                    </th>
                    <td>{{ $product->origin }}</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="thickness" >
                        Thickness
                    </th>
                    <td>{{ $product->thickness }} mm</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="product_height" >
                        Product Height
                    </th>
                    <td>{{ $product->height }} cm</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="product_width">
                        Product Width
                    </th>
                    <td>{{ $product->width }} cm</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="shape">
                        Shape
                    </th>
                    <td>{{ $product->shape }}</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="edges">
                        Edges
                    </th>
                    <td>{{ $product->edges }}</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="total_qty">
                        Total Quantity
                    </th>
                    <td>{{ $product->quantity }}</td>
                </tr>
                <tr>
                    <th>
                        <input type="checkbox" class="spec-checkbox" name="product_checkbox[]" value="no_of_slabs">
                        No. of Slabs
                    </th>
                    <td>{{ $product->slabs }}</td>
                </tr>
            </table>
                      
            <h4 class="mt-4">
                <input type="checkbox" class="spec-checkbox" 
                name="product_checkbox[]" value="description" >
                Description
            </h4>
            <p>{!! $product->description !!}</p>            
        </div>
        <div class="mb-3">
            <label for="checkImages" class="form-label"><strong>Images</strong></label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($product->images as $image)
                    <div class="image-checkbox-container image-box-items">
                        <input type="checkbox" name="images[]" value="{{ $image->id }}"
                            id="product-image-{{ $image->id }}">
                        <label for="product-image-{{ $image->id }}">
                            <img src="{{ Storage::url('/product_images/' . $image->product_id . '/' . $image->image) }}"
                                alt="Product Image">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn buy-btn me-2">Send</button>
    </div>
@endsection
