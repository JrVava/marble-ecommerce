<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read-Only Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            /* max-width: 700px; */
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-check-input {
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
        }

        .readonly-field {
            background-color: #f8f9fa !important;
            border: none;
            pointer-events: none;
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

        .readonly-field {
            background-color: #f8f9fa;
            /* Light background */
            border: 1px solid #ccc;
            /* Subtle border */
            pointer-events: none;
            /* Disable interaction */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Product Details</h2>
                <p class="text-muted">Review product details below</p>
            </div>
            <form method="post" action="{{ route('preview-product.send-product-pdf') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <!-- Product Name -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" name="product_checkbox[]" value="product_name" id="checkProductName">
                    <label class="form-check-label me-3" for="checkProductName">Product Name</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->product_name : '' }}">
                </div>

                <!-- SKU -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="sku" type="checkbox" id="checkSku">
                    <label class="form-check-label me-3" for="checkSku">SKU</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->sku : '' }}">
                </div>

                <!-- Product Origin -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="product_origin" type="checkbox" id="checkProductOrigin">
                    <label class="form-check-label me-3" for="checkProductOrigin">Product Origin</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->product_origin : '' }}">
                </div>

                <!-- Thickness -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="thickness" type="checkbox" id="checkThickness">
                    <label class="form-check-label me-3" for="checkThickness">Thickness</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->thickness : '' }}">
                </div>

                <!-- Product Height -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="product_height" type="checkbox" id="checkHeight">
                    <label class="form-check-label me-3" for="checkHeight">Product Height</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->product_height : '' }}">
                </div>

                <!-- Product Width -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="product_width" type="checkbox" id="checkWidth">
                    <label class="form-check-label me-3" for="checkWidth">Product Width</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->product_width : '' }}">
                </div>

                <!-- Shape -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="shape" type="checkbox" id="checkShape">
                    <label class="form-check-label me-3" for="checkShape">Shape</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->shape : '' }}">
                </div>

                <!-- Edges -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="edges" type="checkbox" id="checkEdges">
                    <label class="form-check-label me-3" for="checkEdges">Edges</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->edges : '' }}">
                </div>

                <!-- Total Quantity -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="total_qty" type="checkbox" id="checkTotalQty">
                    <label class="form-check-label me-3" for="checkTotalQty">Total Quantity</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->total_qty : '' }}">
                </div>

                <!-- Number of Slabs -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="no_of_slabs" type="checkbox" id="checkSlabs">
                    <label class="form-check-label me-3" for="checkSlabs">No of Slabs</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->no_of_slabs : '' }}">
                </div>

                <!-- Product Description -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="description" type="checkbox" id="checkDescription">
                    <label class="form-check-label me-3" for="checkDescription">Description</label>
                    <div class="form-control readonly-field" style="white-space: pre-wrap;">
                        {!! isset($product) ? $product->description : '' !!}
                    </div>
                </div>

                <!-- Rate -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="rate" type="checkbox" id="checkRate">
                    <label class="form-check-label me-3" for="checkRate">Rate</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->rate : '' }}">
                </div>

                <!-- Discount -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input class="form-check-input me-2" name="product_checkbox[]" value="discount" type="checkbox" id="checkDiscount">
                    <label class="form-check-label me-3" for="checkDiscount">Discount</label>
                    <input type="text" class="form-control readonly-field"
                        value="{{ isset($product) ? $product->discount : '' }}">
                </div>

                <!-- Images -->
                <div class="mb-3">
                    <label for="checkImages" class="form-label">Images</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($product->images as $image)
                            <div class="image-checkbox-container">
                                <input type="checkbox" name="images[]" value="{{ $image->id }}" id="product-image-{{ $image->id }}">
                                <label for="product-image-{{ $image->id }}">
                                    <img src="{{ Storage::url('/product_images/' . $image->product_id . '/' . $image->image) }}"
                                        alt="Product Image 1" id="product-image-{{ $image->id }}">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Share</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>