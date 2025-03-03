@extends('layouts.frontend-layout')
@section('content')
    <style>
        /* Custom Card Styling */
        .product-card {
            border: none;
            transition: all 0.3s ease-in-out;
            overflow: hidden;
            box-shadow: 6px 8px 19px 6px rgba(0, 0, 0, 0.2);
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .product-img {
            height: 250px;
            object-fit: cover;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 8px;
        }

        .product-price {
            font-size: 1rem;
            color: #28a745;
            font-weight: bold;
        }

        .product-old-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.9rem;
        }

        .add-to-cart {
            width: 100%;
        }
    </style>

    <div class="container my-4">
        <div class="row" id="product-list">
            @foreach ($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card product-card">
                        <img src="{{ Storage::url('product_images/' . $product->id . '/' . $product->firstImage->image) }}"
                            class="card-img-top product-img" alt="${product.name}">
                        <div class="card-body">
                            <p class="product-title">{{ $product->product_name }}</p>
                            <a href="{{ route('preview-product.index', ['product_id' => $product->id]) }}"
                                class="btn btn-sm btn-primary add-to-cart">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
