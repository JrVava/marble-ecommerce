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
            width: 300px;
            height: auto;
            border-radius: 8px;
        }
    </style>

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
                <h3 class="product-title">{{ $product->product_name ?? '' }}</h3>
                <p class="stock-status">In Stock</p>
                <h4 class="price">₹{{ number_format($product->price, 2) }}</h4>
                <p><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</p>
                <p><strong>Brand:</strong> XYZ</p>
            </div>
        </div>
        <div class="mt-5">
            <table class="spec-table">
                @foreach ([
            'Product Origin' => $product->origin,
            'Thickness' => $product->thickness . ' mm',
            'Product Height' => $product->height . ' cm',
            'Product Width' => $product->width . ' cm',
            'Shape' => $product->shape,
            'Edges' => $product->edges,
            'Total Quantity' => $product->quantity,
            'No. of Slabs' => $product->slabs,
            'Rate' => '₹' . $product->rate,
            'Discount' => $product->discount . '%',
        ] as $label => $value)
                    <tr>
                        <th>{{ $label }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </table>
            <h4 class="mt-4">Description</h4>
            <p>{!! $product->description !!}</p>
        </div>
        <div class="mb-3">
            <label for="checkImages" class="form-label"><strong>Images</strong></label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($product->images as $image)
                    <div class="image-checkbox-container">
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
        <button class="btn buy-btn me-2">Buy Now</button>
        <button class="btn cart-btn">Add to Cart</button>
    </div>
@endsection
